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
      <td style="background: #000000;color:#FFFFFF;"><b>Dictamen protección civil</b></td> 
      <td style="background: #000000;color:#FFFFFF;"><b>Dictamen aforo protección civil</b></td> 
      <td style="background: #000000;color:#FFFFFF;"><b>Comprobante pago predial</b></td> 
      <td style="background: #000000;color:#FFFFFF;"><b>Comprobante de arrendamiento</b></td> 
      <td style="background: #000000;color:#FFFFFF;"><b>Licencia uso de suelo</b></td> 
      <td style="background: #000000;color:#FFFFFF;"><b>Justificant</b></td> 
      <td style="background: #000000;color:#FFFFFF;"><b>Manifiesto no impediment</b></td> 
      <td style="background: #000000;color:#FFFFFF;"><b>Anuencia municipal</b></td> 
      <td style="background: #000000;color:#FFFFFF;"><b>Pago de anuencia</b></td> 
      <td style="background: #000000;color:#FFFFFF;"><b>Pago de impuestos estatales</b></td> 
    </tr>
  </thead>
  <tbody>
    @foreach($data as $row) 
        <tr>
            <td>#{{ $row['id'] }}</td>
            <td>{{ $row['user'] }}</td>
            <td>{{ $row['colonie'] }}</td>
            <td>{{ $row['perm1'] }}</td>
            <td>{{ $row['perm2'] }}</td>
            <td>{{ $row['perm3'] }}</td>
            <td>{{ $row['perm4'] }}</td>
            <td>{{ $row['perm5'] }}</td> 
            <td>{{ $row['perm6'] }}</td> 
            <td>{{ $row['perm7'] }}</td> 
            <td>{{ $row['perm8'] }}</td> 
            <td>{{ $row['perm9'] }}</td> 
            <td>{{ $row['perm10'] }}</td> 
        </tr>
    @endforeach   
    </tbody>
</table>
 
</body>
</html>