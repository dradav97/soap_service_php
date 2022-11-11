<?php

require_once "econea/nusoap/src/nusoap.php";

$namespace = "miSuperSoap2020.alv";
$server = new soap_server();
$server->configureWSDL("PinchesSOAP",$namespace);
$server->wsdl->schemaTargetNamespace = $namespace;

$server->wsdl->addComplexType(
    'ordenDeCompra',
    'complexType',
    'struct',
    'all',
    '',
    array(
        'NumeroOrden' => array('name' => 'NumeroOrden', 'type'=>'xsd:string'),
        'Ordenante' => array('name' => 'Ordenante', 'type'=>'xsd:string'),
        'Moneda' => array('name' => 'Moneda', 'type'=>'xsd:string'),
        'TipoCambio' => array('name' => 'TipoCambio', 'type'=>'xsd:decimal')
    )
);

$server->wsdl->addComplexType(
    'response',
    'complexType',
    'struct',
    'all',
    '',
    array(
        'NumeroDeAutorizacion' => array('name'=>'NumeroDeAutorizacion', 'type'=>'xsd:string'),
        'Resultado' => array('name' => 'Resultado', 'type' => 'xsd:boolean')
    )
);

$server->register(
    'guardarOrdenDeCompra',
    array('name' => 'tns:ordenDeCompra'),
    array('name' => 'tns:response'),
    $namespace,
    false,
    'rpc',
    'encoded',
    'Recibe una orden de compra y regresa un número de autorización'
);

function guardarOrdenDeCompra($request){
    return array(
        "NumeroDeAutorizacion" => "La orden de compra ".$request["NumeroOrden"]." ha sido autorizada con el número ". rand(10000, 100000),
        "Resultado" => true
    );
}

$POST_DATA = file_get_contents("php://input");
$server->service($POST_DATA);
exit();