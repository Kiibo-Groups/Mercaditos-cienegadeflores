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
      <td style="background: #000000;color:#FFFFFF;width:150px;"><b>Fotografia de perfil</b></td>
      <td style="background: #000000;color:#FFFFFF;width:150px;"><b>Fotografia de ine frontal</b></td>
      <td style="background: #000000;color:#FFFFFF;width:150px;"><b>Fotografia de ine tracera</b></td>
      <td style="background: #000000;color:#FFFFFF;width:350px;"><b>Contribuyente</b></td>
      <td style="background: #000000;color:#FFFFFF;width:100px;"><b>Giro</b></td>
      <td style="background: #000000;color:#FFFFFF;width:100px;"><b>Colonia</b></td>
      <td style="background: #000000;color:#FFFFFF;width:100px;"><b>Metros</b></td>
      <td style="background: #000000;color:#FFFFFF;width:100px;"><b>Costo</b></td> 
      <td style="background: #000000;color:#FFFFFF;width:100px;"><b>Extra</b></td> 
    </tr>
  </thead>
  <tbody>
    @foreach($data as $row) 
        <tr>
        <td style="width:150px;vertical-align:middle;text-align:center;" align="center"><img src="{{ $row['pic_profile'] }}" width="50px" height="auto" > </td>
        <td style="width:150px;vertical-align:middle;text-align:center;" align="center"><img src="{{ $row['pic_ine_front'] }}" width="50px" height="auto" > </td>
        <td style="width:150px;vertical-align:middle;text-align:center;" align="center"><img src="{{ $row['pic_ine_back'] }}" width="50px" height="auto" > </td>
        <td style="vertical-align:middle;width:350px;text-align:center;" >{{ $row['contribuyente'] }}</td>
        <td style="vertical-align:middle;width:100px;text-align:center;">{{ $row['giro'] }}</td>
        <td style="vertical-align:middle;width:100px;text-align:center;">{{ $row['colonia'] }}</td>
        <td style="vertical-align:middle;width:100px;text-align:center;">{{ $row['metros'] }}</td>
        <td style="vertical-align:middle;width:100px;text-align:center;">{{ $row['costo'] }}</td> 
        <td style="vertical-align:middle;width:100px;text-align:center;">{{ $row['extras'] }}</td>
        </tr>
    @endforeach   
    </tbody>
</table>
 
</body>
</html>