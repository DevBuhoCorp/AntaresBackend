@php
    $subtotal = 0;
    $iva = 0;
    $total = 0;
@endphp
<html>
  <head>
   <!--  <link rel="stylesheet" href="{{ url('assets/css/style.css') }}"> -->
   <link rel="stylesheet" type="text/css" media="all" href="assets/css/style.css" />
   <style type="text/css">
/*<![CDATA[*/
@page {
     margin: 0;
}
/*]]>*/
</style>

  </head>
  <body>
    <header class="clearfix">
      <div id="logo">
        <img src="assets/img/logo.png">
      </div>
      <h1>ORDEN DE COMPRA</h1>
      <!-- <div id="company" class="clearfix">
        <div>Emisor:</div>
        <div>Cuerpo de Bomberos Municipal de Quevedo</div>
        <div>Calle Bolívar y Tercera, <br /> Quevedo - Los Ríos</div>
        <div>Emergencias ECU911 - Oficinas 052752176 - 052750331</div>
        <div><a href="mailto:cbmqcentral@outlook.com">cbmqcentral@outlook.com</a></div>
      </div>
      <div id="project">
        <div><span>PROVEEDOR: </span> {{$detalles[0]->ordencompra->proveedor->RazonSocial}}</div>
        <div><span>DIRECCIÓN: </span> {{$detalles[0]->ordencompra->proveedor->Direccion}}</div>
        <div><span>EMAIL: </span> <a href="{{$detalles[0]->ordencompra->proveedor->Email}}">{{$detalles[0]->ordencompra->proveedor->Email}}</a></div>
        <div><span>FECHA: </span> {{Carbon\Carbon::now('America/Guayaquil')}}</div>
        <div><span>FECHA PREVISTA DE ENTREGA: </span> {{$detalles[0]->ordencompra->FechaEntrega}}</div>
      </div>-->

      <div id="project">
        <div><span>ORDEN DE COMPRA A : </span> {{$detalles[0]->ordencompra->proveedor->RazonSocial}}</div>
        <div>{{$detalles[0]->ordencompra->proveedor->Direccion}}</div>
      </div>

      <div id="company" class="clearfix">
      <div><span>FECHA: </span> {{Carbon\Carbon::today('America/Guayaquil')->toDateString()}}</div>
      </div>
    </header>
    <main>
      <table >
        <thead>
          <tr>
            <th class="desc">DESCRIPCIÓN</th>
            <th>CANTIDAD</th>
            <th>PRECIO</th>
            <th>TOTAL</th>
          </tr>
        </thead>
        <tbody>
        @foreach ($detalles as $detalle)
        <tr>
        <td class="desc">{{ $detalle->Descripcion }}</td>
        <td class="qty">{{ $detalle->Cantidad }}</td>
        <td class="unit">${{ $detalle->Precio }}</td>
        <td class="total">${{ $detalle->Cantidad * $detalle->Precio }}</td>
        {{ $subtotal += $detalle->Cantidad * $detalle->Precio }}
        </tr>
        @endforeach



        </tbody>
      </table>

      <table >
      <tbody>
      <tr>
            <td colspan="3">SUBTOTAL</td>
            <td class="total">${{ $subtotal}}</td>
          </tr>
          <tr>
            <td colspan="3">IVA 12%</td>
            <td class="total">${{ $iva = $subtotal * 0.12 }}</td>
          </tr>
          <tr>
            <td colspan="3" class="grand total"> TOTAL</td>
            <td class="grand total">${{$total = $subtotal + $iva}}</td>
          </tr>
          </tbody>
</table>
      <div id="notices">
        <div class="header"> Información de Pago:</div>
        <div class="notice">Condiciones de pago: {{$detalles[0]->ordencompra->modopago->Etiqueta}}</div>
        <div class="notice">Forma de pago: {{$detalles[0]->ordencompra->condicionpago->Etiqueta}}.</div>
      </div>
    </main>
    <footer>
          Antares. Buhocorp©
    </footer>
  </body>
</html>
