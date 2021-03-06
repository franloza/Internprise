<?php


namespace es\ucm\aw\internprise;


class PortalAdministracion extends Portal
{
    public function __construct() {
        parent::__construct("Admin");
    }

    public function generaMenu()
    {
        $bloqueAdminSideBar = <<<EOF
        <!-- Fragmento para definir el menú de administrador-->
        <div id="admin-sidebar" class="sidebar">
                <ul>
                    <li onmouseenter="subMenu(true, 'sub-menu-ofertas')" onmouseleave="subMenu(false, 'sub-menu-ofertas')">
                        <a onclick="subMenu(true, 'sub-menu-ofertas')" href="#">OFERTAS</a>
                        <div id="sub-menu-ofertas" class="sub-menu">
                            <ul>
                                <li><a onclick="return loadContent('OFERTAS_CLASIFICADAS', 'Ofertas clasificadas')" href="#">Clasificadas</a></li>
                                <li><a onclick="return loadContent('OFERTAS_NO_CLASIFICADAS', 'Ofertas no clasificadas')" href="#">No clasificadas</a></li>
                            </ul>
                        </div>
                    </li>
                    <li onmouseenter="subMenu(true, 'sub-menu-demandas')" onmouseleave="subMenu(false, 'sub-menu-demandas')">
                        <a onclick="subMenu(true, 'sub-menu-demandas')" href="#">DEMANDAS</a>
                        <div id="sub-menu-demandas" class="sub-menu">
                            <ul>
                                <li><a onclick="return loadContent('DEMANDAS_CLASIFICADAS', 'Demandas clasificadas')" href="#">Clasificadas</a></li>
                                <li><a onclick="return loadContent('DEMANDAS_NO_CLASIFICADAS', 'Demandas no clasificadas')" href="#">No clasificadas</a></li>
                            </ul>
                        </div>
                    </li>
                    <li><a onclick="return loadContent('CONTRATOS', 'Contratos')" href="#">VER CONTRATOS</a></li>
                    <li><a onclick="return loadContent('HISTORIAL', 'Historial')" href="#">HISTORIAL</a></li>
                    <!--<li> <a onclick="return loadContent('BUZON', 'Buzon')" href="#">BUZÓN</a></li>-->
                </ul>
        </div>
EOF;
        return $bloqueAdminSideBar;
    }
    
    /**
     * Función que genera los encabezados de la página.
     */
    public function generaHead()
    {
        $titulo = "Internprise - Portal Administracion";
        $imagen = "img/favicon-admin.png";
        return parent::generaHeadParam($titulo,$imagen);
    }
	
    /**
     * Función que genera el contenido de la página principal del portal.
     * El resto de contenido debe generarse por medio de peticiones AJAX.
     */
    public function generaDashboard()
    {
       $widgets="";
       $buscador = <<<EOF
       <div class="dashboard-content">
           <!-- INI Contenedor Widgets superior -->
           <div class="widget-content">
EOF;

        //TIPOS DE ICONOS PARA LOS WIDGETS: envelope-o,check-circle,caret-square-o-down,commenting-o (VER FONTAWESOME ICONS)

        /*Generar contenido widget Ofertas */
        $widgets .= "<!-- INI Widget Ofertas activos -->";
        $ofertas = OfertaDAO::cargaOfertasNoClasificadas(5,null);
        $listaOfertas = array();
        foreach ( $ofertas as $oferta) {
            $titleItem = $oferta->getEmpresa();
            $subtitleItem = $oferta->getPuesto();
            $dias = $oferta->getDiasDesdeCreacion();
            if ($dias == 0) {$description = "Hoy";} else if ($dias == 1) {$description = "Ayer";} else {$description ="Hace " . $dias . " dias";};
            $item = array($titleItem,$subtitleItem,$description);
            array_push($listaOfertas,$item);
        }
        $numNewOfertas = OfertaDAO::countOfertasSinClasificar();
        $widgets .= parent::generarWidget("Nuevas ofertas sin clasificar", $listaOfertas,"envelope-o","blue",$numNewOfertas);
        $widgets .= "<!-- FIN Widget Ofertas activos -->";

        /*Generar contenido widget Contratos */
        $widgets .= "<!-- INI Widget Contratos activos -->";
        $contratos = ContratoDAO::cargaContratosAExpirar(null, null);
        $listaContratos = array();
        foreach ( $contratos as $contrato) {
            $estudiante = $contrato->getEstudiante();
            $titleItem = $estudiante->getApellidos() . ", " . $estudiante->getNombre();
            $subtitleItem = $contrato->getEmpresa();
            $description = $contrato->getFechaFin();
            $item = array($titleItem,$subtitleItem,$description);
            array_push($listaContratos,$item);
        }
        $numContratos = count($contratos);
        $widgets .= parent::generarWidget("Contratos pendientes de expirar", $listaContratos,"check-circle","green",$numContratos);
        $widgets .= "<!-- FIN Widget Contratos activos -->\n<!-- FIN Contenedor widgets superior -->";

        $widgets .= "<!-- INI Contenedor widgets inferior -->\n<!-- INI Contenedor widgets inferior -->";

        /*Generar contenido widget Demandas */
        $widgets .= "<!-- INI Widget Nuevas demandas -->";
        $demandas = DemandaDAO::cargaDemandasNoClasificadas(5,null);
        $listaDemandas = array();
        if($demandas) {
            foreach ($demandas as $demanda) {
                $titleItem = $demanda->getEstudiante()->getNombre() . " " . $demanda->getEstudiante()->getApellidos();
                $subtitleItem = $demanda->getOferta()->getPuesto();
                $dias = $demanda->getDiasDesdeCreacion();
                if ($dias == 0) {
                    $description = "Hoy";
                } else if ($dias == 1) {
                    $description = "Ayer";
                } else {
                    $description = "Hace " . $dias . " dias";
                };
                $item = array($titleItem, $subtitleItem, $description);
                array_push($listaDemandas, $item);
            }
        }
        $numNewDemandas = DemandaDAO::countDemandasNoClasificadas();
        $widgets .= parent::generarWidget("Nuevas demandas sin clasificar", $listaDemandas," fa-caret-square-o-down","#FF800D",$numNewDemandas);
        $widgets .= "<!-- FIN Widget Nuevas demandas -->";

        $content = $buscador . $widgets;
        $content .= "</div>";
        $content .= "</div>";
       return $content;
    }

    public function generaTitlebar()
    {
        return parent::generaTitlebarParam("Internprise Administración");
    }

    public function generaOfertas($clasificadas){
        if ($clasificadas)
            $ofertas = OfertaDAO::cargaOfertasClasificadas(30, null);
        else
            $ofertas = OfertaDAO::cargaOfertasNoClasificadas(30, null);
        $listaOfertas = array();
        $listaIds = array();
        foreach ( $ofertas as $oferta) {
            $empresa = $oferta ->getEmpresa();
            $puesto = $oferta->getPuesto();
            $sueldo = $oferta->getSueldo();
            $horas = $oferta->getHoras();
            $plazas = $oferta->getPlazas();
            $estado = $oferta->getEstado();
            $fila = array($empresa, $puesto,$sueldo, $horas, $plazas, $estado);
            array_push($listaOfertas,$fila);
            array_push($listaIds, $oferta->getIdOferta());
        }
        $titulosColumnas = array("Empresa", "Puesto", "Sueldo", "Horas", "Plazas", "Estado");
        $content = self::generaTabla("tabla-oferta","admin-table" ,
            "Ofertas" . (($clasificadas)? ' ' : ' no ') . 'clasificadas',
                $titulosColumnas, $listaOfertas, $listaIds, 'oferta');
        return $content;

    }

    public function generaDemandas($clasificadas){
        if ($clasificadas)
            $demandas = DemandaDAO::cargaDemandasClasificadas(30, null);
        else
            $demandas = DemandaDAO::cargaDemandasNoClasificadas(30, null);
        $listaDemandas = array();
        $listaIds = array();
        foreach ( $demandas as $demanda) {
            $oferta = $demanda->getOferta();
            $estudiante = $demanda->getEstudiante();
            $nombreEstudiante = $estudiante->getNombre() . " " . $estudiante->getApellidos();
            $empresa = $oferta ->getEmpresa();
            $puesto = $oferta->getPuesto();
            $sueldo = $oferta->getSueldo();
            $horas = $oferta->getHoras();
            $estado = $demanda->getEstado();
            $fila = array($nombreEstudiante,$empresa, $puesto,$sueldo, $horas,$estado);
            array_push($listaDemandas,$fila);
            array_push($listaIds, $demanda->getIdDemanda());
        }
        $titulosColumnas = array("Estudiante","Empresa", "Puesto", "Sueldo", "Horas", "Estado");
        $content = self::generaTabla("tabla-oferta","admin-table" ,
            "Demandas" . (($clasificadas)? ' ' : ' no ') . 'clasificadas',
            $titulosColumnas, $listaDemandas, $listaIds, 'demanda');
        return $content;
    }

    public function generaContratos(){
    	$contratos = ContratoDAO::cargaContratosActivos(20,null);

        $listaContratos = array();
        $listaIds = array();
        foreach ( $contratos as $contrato) {
            $estudiante = $contrato->getEstudiante();
            $nombreEstudiante = $estudiante->getNombre() . " " . $estudiante->getApellidos();
            $empresa = $contrato->getEmpresa();
            $puesto = $contrato->getPuesto();
            $fecha_inicio = $contrato->getFechaInicio();
            $fecha_fin = $contrato->getFechaFin();
            $estado = $contrato->getEstado();
            $fila = array($nombreEstudiante, $empresa,$puesto, $fecha_inicio, $fecha_fin,$estado);
            array_push($listaContratos,$fila);
            array_push($listaIds, $contrato->getIdContrato());
        }
        $titulosColumnas = array("Estudiante", "Empresa", "Puesto", "Inicio", "Fin","Estado");
        $content = self::generaTabla("tabla-contrato","admin-table" ,
            "Contratos", $titulosColumnas, $listaContratos, $listaIds, 'contrato');
        return $content;
    }
    public function generaHistorial(){
        $contratos = ContratoDAO::cargaContratosFinalizados(20,null,date("Y"));

        $listaContratos = array();
        $listaIds = array();
        foreach ( $contratos as $contrato) {
            $estudiante = $contrato->getEstudiante();
            $nombreEstudiante = $estudiante->getNombre() . " " . $estudiante->getApellidos();
            $empresa = $contrato->getEmpresa();
            $puesto = $contrato->getPuesto();
            $fecha_inicio = $contrato->getFechaInicio();
            $fecha_fin = $contrato->getFechaFin();
            $estado = $contrato->getEstado();
            $fila = array($nombreEstudiante, $empresa,$puesto, $fecha_inicio, $fecha_fin,$estado);
            array_push($listaContratos,$fila);
            array_push($listaIds, $contrato->getIdContrato());
        }
        $titulosColumnas = array("Estudiante", "Empresa", "Puesto", "Inicio", "Fin","Estado");
        $content = self::generaTabla("tabla-contrato","admin-table" ,
            "Contratos", $titulosColumnas, $listaContratos, $listaIds, 'contrato');
        return $content;
    }
    public function generaBuzon(){		
       // TODO: Implement generaBuzon() method.		
    }
    public function generaSettings(){
        $formAdmin =  new \es\ucm\aw\internprise\FormularioSettings('admin');
        $formAdmin->gestiona();
    }
}
