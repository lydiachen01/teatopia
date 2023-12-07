// TIP: Run "npm i nodemon" to download nodemon node module
//      Allows for automatic server reloads

// Run server.js: node server.js
// Will run both the backend for user creation and user authenication for signup and logn

const express = require('express');
const app = express();
const bcrypt = require('bcrypt');
const path = require('path');

// Middleware to parse JSON in the request body
app.use(express.json());

// Dummy user for demonstration purposes
const users = [{
    "email": "a@a.com", 
    "password": "$2b$10$gFsmbxo.r.wPaKowIiyFg.6Dn0cKY.HRLhMKkcYU1CkYNQ62QTOXS" // Hashed password equivalent to "pumpkin" in plain text
}];

// const salt = bcrypt.genSaltSync();
// const hashedPassword = bcrypt.hashSync('pumpkin', salt);

// console.log('Salt:', salt);
// console.log('Hashed Password:', hashedPassword);
// console.log("This is users:", users);

// GET endpoint for login.html
app.get('/login.html', (req, res) => {
    res.sendFile(path.join(__dirname, 'login.html'));
});

// GET endpoint for user-profile.html
app.get('/user_profile.html', (req, res) => {
    res.sendFile(path.join(__dirname, 'user_profile.html'));
});

// POST endpoint for user login
app.post('/login', async (req, res) => {
    console.log(req.body);

    const { email, password } = req.body;
    const user = users.find(user => user.email == email);

    if (!user) {
        return res.status(400).json({ error: "Cannot find user" });
    }

    try {
        if (await bcrypt.compare(password, user.password)) {
            // res.json({ success: true, message: "Login successful" });
            res.redirect('/user_profile.html');
        } else {
            res.status(401).json({ error: "Incorrect password" });
        }
    } catch (error) {
        console.error(error);
        res.status(500).json({ error: "Internal server error" });
    }
});

// Start the server
const PORT = 5500;
const HOST = '127.0.0.1';

app.listen(PORT, HOST, () => {
    console.log(`Server is running on http://${HOST}:${PORT}/login`);
});