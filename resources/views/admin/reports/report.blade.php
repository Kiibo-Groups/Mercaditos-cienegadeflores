<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
<table>
  <thead>
    <tr>
      <td style="background: #000000;color:#FFFFFF;"><b>id</b></td>
      <td style="background: #000000;color:#FFFFFF;"><b>Usuario</b></td>
      <td style="background: #000000;color:#FFFFFF;"><b>Colonia</b></td>
      <td style="background: #000000;color:#FFFFFF;"><b>Contribuyente</b></td>
      <td style="background: #000000;color:#FFFFFF;"><b>Giro</b></td>
      <td style="background: #000000;color:#FFFFFF;"><b>Metros</b></td>
      <td style="background: #000000;color:#FFFFFF;"><b>Costo</b></td> 
      <td style="background: #000000;color:#FFFFFF;"><b>Extra</b></td> 
    </tr>
  </thead>
  <tbody>
    @foreach($data as $row) 
        <tr>
        <td>#{{ $row['id'] }}</td>
        <td>{{ $row['user'] }}</td>
        <td>{{ $row['colonie'] }}</td>
        <td>{{ $row['contribuyente'] }}</td>
        <td>{{ $row['giro'] }}</td>
        <td>{{ $row['metros'] }}</td>
        <td>{{ $row['costo'] }}</td> 
        <td>{{ $row['extras'] }}</td>
        </tr>
    @endforeach   
    </tbody>
</table>
 
</body>
</html>