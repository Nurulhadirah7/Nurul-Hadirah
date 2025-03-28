from flask import Flask, render_template, request, redirect, url_for, session, g, flash
import sqlite3
from datetime import datetime, timedelta
from werkzeug.security import generate_password_hash, check_password_hash
from itsdangerous import URLSafeTimedSerializer

app = Flask(__name__)
app.secret_key = 'your_secret_key_here'  # Change this in production
serializer = URLSafeTimedSerializer(app.secret_key)
DATABASE = 'members.db'

# Security Configurations
app.config['SESSION_COOKIE_SECURE'] = False  # Set to True in production
app.config['SESSION_COOKIE_HTTPONLY'] = True
app.config['SESSION_COOKIE_SAMESITE'] = 'Lax'
PASSWORD_EXPIRATION_DAYS = 90

# User Store with hashed passwords
USERS = {
    "staff": {"password": generate_password_hash("staffpass"), "role": "staff", "last_changed": datetime.utcnow()},
    "member": {"password": generate_password_hash("memberpass"), "role": "member", "last_changed": datetime.utcnow()},
    "pakkarim": {"password": generate_password_hash("karim"), "role": "staff", "last_changed": datetime.utcnow()}
}

# Database Connection
def get_db():
    db = getattr(g, '_database', None)
    if db is None:
        g._database = sqlite3.connect(DATABASE)
        g._database.row_factory = sqlite3.Row
    return g._database

@app.teardown_appcontext
def close_connection(exception=None):
    db = getattr(g, '_database', None)
    if db:
        db.close()

def query_db(query, args=(), one=False):
    """ Executes a database query and returns the result """
    with get_db() as db:
        cur = db.execute(query, args)
        result = cur.fetchall()
        cur.close()
    return (result[0] if result else None) if one else result

def modify_db(query, args=()):
    """ Executes a database modification and commits the changes """
    with get_db() as db:
        db.execute(query, args)
        db.commit()

# Create tables before first request
@app.before_request
def create_tables():
    db = get_db()
    db.executescript('''
        CREATE TABLE IF NOT EXISTS members (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            membership_status TEXT NOT NULL
        );
        CREATE TABLE IF NOT EXISTS classes (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            class_name TEXT NOT NULL,
            class_time TEXT NOT NULL
        );
        CREATE TABLE IF NOT EXISTS member_classes (
            member_id INTEGER,
            class_id INTEGER,
            FOREIGN KEY (member_id) REFERENCES members (id),
            FOREIGN KEY (class_id) REFERENCES classes (id)
        );
    ''')
    db.commit()

# Home Route (Login)
@app.route('/', methods=['GET', 'POST'])
def login():
    if request.method == 'POST':
        username = request.form['username']
        password = request.form['password']

        user = USERS.get(username)
        if user and check_password_hash(user['password'], password):
            if datetime.utcnow() - user['last_changed'] > timedelta(days=PASSWORD_EXPIRATION_DAYS):
                return "Password expired. Contact admin to reset."

            session['user'] = serializer.dumps(username)
            session['role'] = user['role']
            return redirect(url_for('dashboard'))
        else:
            return "Login Failed!"
    return render_template('login.html')

@app.route('/dashboard')
def dashboard():
    if 'user' not in session:
        return redirect(url_for('login'))
    
    try:
        username = serializer.loads(session['user'])
    except:
        return redirect(url_for('logout'))  # Handle session corruption
    
    return render_template('dashboard.html', username=username)

# Add Member Route (Staff Only)
@app.route('/add_member', methods=['GET', 'POST'])
def add_member():
    if 'user' not in session or session.get('role') != 'staff':
        return redirect(url_for('login'))
    
    if request.method == 'POST':
        name = request.form['name']
        status = request.form['status']
        modify_db("INSERT INTO members (name, membership_status) VALUES (?, ?)", (name, status))
        flash("Member added successfully!", "success")
        return redirect(url_for('view_members'))
    
    return render_template('add_member.html')

# View Members Route
@app.route('/view_members')
def view_members():
    if 'user' not in session or session.get('role') != 'staff':
        return redirect(url_for('login'))
    members = query_db("SELECT * FROM members")
    return render_template('view_members.html', members=members)

# Delete Member Route (Fixed!)
@app.route('/delete_member/<int:member_id>', methods=['POST'])
def delete_member(member_id):
    if 'user' not in session or session.get('role') != 'staff':
        return redirect(url_for('login'))
    
    modify_db("DELETE FROM members WHERE id = ?", (member_id,))
    flash("Member deleted successfully!", "success")
    return redirect(url_for('view_members'))

# Route to view classes
@app.route('/view_classes')
def view_classes():
    if 'user' not in session:
        return redirect(url_for('login'))
    classes = query_db("SELECT * FROM classes")
    return render_template('view_classes.html', classes=classes)

# Register a member for a class
@app.route('/register_class', methods=['POST'])
def register_class():
    if 'user' not in session:
        return redirect(url_for('login'))
    
    member_id = request.form.get('member_id')
    class_id = request.form.get('class_id')

    if member_id and class_id:
        modify_db("INSERT INTO member_classes (member_id, class_id) VALUES (?, ?)", (member_id, class_id))
        flash("Member successfully registered for class!", "success")
    
    return redirect(url_for('view_classes'))

# View classes for a specific member
@app.route('/member_classes/<int:member_id>')
def member_classes(member_id):
    if 'user' not in session:
        return redirect(url_for('login'))
    
    classes = query_db("SELECT classes.class_name, classes.class_time FROM member_classes "
                       "JOIN classes ON member_classes.class_id = classes.id "
                       "WHERE member_classes.member_id = ?", (member_id,))
    
    return render_template('member_classes.html', classes=classes, member_id=member_id)

# Logout
@app.route('/logout')
def logout():
    session.clear()  # Clear all session data
    return redirect(url_for('login'))

if __name__ == '__main__':
    app.run(debug=True)
