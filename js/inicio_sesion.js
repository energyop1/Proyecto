document.getElementById('registro-link').addEventListener('click', function(e) {
    e.preventDefault();
    document.getElementById('login-container').style.display = 'none';
    document.getElementById('registro-container').style.display = 'block';
});

document.getElementById('login-link').addEventListener('click', function(e) {
    e.preventDefault();
    document.getElementById('registro-container').style.display = 'none';
    document.getElementById('login-container').style.display = 'block';
});



