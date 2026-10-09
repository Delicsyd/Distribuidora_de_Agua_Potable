<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
     <h1>Iniciar sesion</h1>
     @if ($errors->any())
     <div>
        {{  $errors->first() }}
     </div>

     
     @endif 
     <form action="{{ route('login.procesar') }}" method="POST">

       @csrf

       <label for="usuario">Usuario:</label>
       <input type="text" name="usuario" id="usuario">

       <br><br>


       <label for="contraseña">Contraseña:</label>
       <input type="password" name="contraseña" id="contraseña">


         <br><br>
         
          <button type="submit">Iniciar sesión</button>



       </form>
    
</body>
</html>