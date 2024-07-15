<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>

<img src="https://mercaditos-cienegadeflores.com/assets/images/logo.png" alt="logo" style="width: 150px;">
<br />

<table style="margin-top: 25px">
    <thead>
        <tr> 
            <td style="width: 50%;background: #000000;color:#FFFFFF;"><b>Nombre de usuario</b></td>    
            <td style="width: 350%;"></td>    
        </tr>
         
    </thead>
    <tbody>
        <tr>
            <td style="width: 50%">{!! $user_info !!}</td> 
            <td style="width: 350%;"></td>    
        </tr> 
         
    </tbody>
</table>

<table>
  <thead>
    <tr> 
      <td style="width: 50%;background: #000000;color:#FFFFFF;"><b>Fecha</b></td>  
      <td style="width: 350%;background: #000000;color:#FFFFFF;"><b>Colonia</b></td>  
      <td style="background: #000000;color:#FFFFFF;"><b>Contribuyente</b></td>
      <td style="background: #000000;color:#FFFFFF;"><b>Giro</b></td>
      <td style="background: #000000;color:#FFFFFF;"><b>Metros</b></td>
      <td style="background: #000000;color:#FFFFFF;"><b>Costo</b></td>   
      <td style="background: #000000;color:#FFFFFF;"><b>Extras</b></td>   
      <td style="background: #000000;color:#FFFFFF;"><b>Identificador</b></td>     
    </tr>
  </thead>
  <tbody>
    @foreach($data as $row) 
        @foreach ($row['colonies'] as $item)
            <tr>
                <td style="width: 50%;">{{ $item['fecha'] }}</td>  
                <td style="width: 350%;">{{ $item['colonie'] }}</td>  
                <td style="">{{ $item['contribuyenye'] }}</td> 
                <td style="">{{ $item['giro'] }}</td> 
                <td style="">{{ $item['metros'] }}</td> 
                <td style="">{{ number_format($item['costo'], 2) }}</td>  
                <td style="">{{ number_format($item['extras'], 2) }}</td> 
                <td style="">{{ $item['identifier'] }}</td> 
            </tr>
        @endforeach
        <tr>  
            <td style="width: 50%;"></td>  
            <td style="width: 350%;"></td>  
            <td style=""></td> 
            <td style=""></td> 
            <td style=""></td> 
            <td style=""></td>  
            <td style=""></td>  
            <td style=""></td>   
        </tr>
        <tr>  
            <td style="width: 50%;"></td>  
            <td style="width: 350%;"></td>  
            <td style=""></td> 
            <td style=""></td> 
            <td style=""></td> 
            <td style=""></td>  
            <td style=""></td>  
            <td style="background: #000000;color:#FFFFFF;">total ${{ number_format($row['total'],2) }}</td>   
        </tr>
         
    @endforeach   
    </tbody>
</table>
  

</body>
</html>