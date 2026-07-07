<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin | Sentra Hotels</title>
    <style>
        body { font-family: sans-serif; background: #f4efe6; display: flex; justify-content: center; align-items: center; height: 100vh; margin: 0; }
        .login-box { background: white; padding: 40px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); width: 100%; max-width: 320px; }
        input { width: 100%; padding: 10px; margin: 10px 0 20px; border: 1px solid #ccc; box-sizing: border-box; outline: none; }
        input:focus { border-color: #b88746; }
        button { width: 100%; padding: 12px; background: #b88746; color: white; border: none; font-weight: bold; cursor: pointer; border-radius: 4px; }
        button:hover { background: #9c723b; }
        .error { color: red; font-size: 14px; margin-bottom: 10px; text-align: center; }
        h2 { text-align: center; color: #15120e; }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Admin Login</h2>
        
        @if($errors->any()) 
            <div class="error">{{ $errors->first() }}</div> 
        @endif

        <form method="POST" action="{{ url('/login') }}">
            @csrf
            <label>Email</label>
            <input type="email" name="email" required>
            
            <label>Password</label>
            <input type="password" name="password" required>
            
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>