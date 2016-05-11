<?php


namespace es\ucm\aw\internprise;


class PortalAdministracion extends Portal
{
    public function __construct() {
        parent::__construct("Admin");
    }

    public function generaMenu()
    {
        //TODO:Peticiones AJAX para coonseguir contenido
        $bloqueAdminSideBar = <<<EOF
        <!-- Fragmento para definir el menú de administrador-->
        <div id="admin-sidebar" class="sidebar">
                <ul>
                    <li><a onclick="return loadContent('OFERTAS_ADMIN')" href="#">OFERTAS</a></li>
                    <li><a onclick="return loadContent('DEMANDAS_ADMIN')" href="#">DEMANDAS</a></li>
                    <li><a onclick="return loadContent('CONTRATOS_ADMIN')" href="#">VER CONTRATOS</a></li>
                    <li><a onclick="return loadContent('HISTORIAL_ADMIN')" href="#">HISTORIAL</a></li>
                    <li><a onclick="return loadContent('ENCUESTAS_ADMIN')" href="#">ENCUESTAS</a></li>
                    <li><a onclick="return loadContent('BUZON_ADMIN')" href="#">BUZON</a></li>
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
        
        // ***************************************************************************************************
        // TODO: NECESITO QUERY PARA TRAER ULTIMAS OFERTAS
        //       datos que necesito:
        //                          - Nombre empresa
        //                          - Descripcion
        //                          - Tiempo desde que se creo o simplemente la hora y ya lo calculo yo
        // ***************************************************************************************************

        $contenido="";
        $buscador = <<<EOF
        <div class="dashboard-content">

			<!-- INI Contenedor busqueda dashboard -->
			<div class="btn-search">
				<a class="icon-search" href="#">
					<i class="fa fa-search fa-2x" style="color:#444;"></i>
				</a>
				<div class="txt-search">
					<form method="post" action="#">
						<input class="txt-search" type="text" placeholder="Buscador de estudiantes / empresas">
					</form>
				</div>
			</div>	            
			<!-- FIN Contenedor busqueda dashboard -->
			
			<!-- INI Contenedor Widgets superior -->
			<div class="widget-content">
EOF;

        $ofertas = generarWidget("Ofertas", 5);
        $widgets = <<<EOF
            <!-- FIN Widget Nuevas ofertas -->  

            
            <!-- INI Widget Contratos activos -->   
            <div class="widget">
                <!-- Header widget -->
                <div class="widget-header">
                    <p class="title">Contratos activos</p>
                    <p class="title-items">
                        <a class="square" href="#">6</a>
                    </p>
                </div>
                <!-- Content widget -->
                <div class="content-widget">
                    <div class="media">
                        <div class="media-left">
                            <i class="fa fa-check-circle" style="color:green;" aria-hidden="true"></i>
                        </div>
                        <div class="media-body">
                            <div class="media-header">
                                <strong>Ubisoft</strong>
                                Jos&eacute; Miguel Maldonado
                            </div>
                            <div class="text-muted">
                                <small>Hace 5 dias</small>
                            </div>
                        </div>
                    </div>
                <div class="media">
                    <div class="media-left">
                        <i class="fa fa-check-circle" style="color:green;" aria-hidden="true"></i>
                    </div>
                    <div class="media-body">
                        <div class="media-header">
                            <strong>Seltime</strong>
                            Francisco Jos&eacute; Lozano
                        </div>
                    <div class="text-muted">
                        <small>Hace 6 dias</small>
                    </div>
                </div>
            </div>
            <div class="media">
                            <div class="media-left">
                                <i class="fa fa-check-circle" style="color:green;" aria-hidden="true"></i>
                            </div>
                            <div class="media-body">
                                <div class="media-header">
                                    <strong>Cpl</strong>
    H&eacute;ctor Malag&oacute;n
    </div>
                                <div class="text-muted">
                                    <small>Hace 12 dias</small>
                                </div>
                            </div>
                        </div>
                        <div class="media">
                            <div class="media-left">
                                <i class="fa fa-check-circle" style="color:green;" aria-hidden="true"></i>
                            </div>
                            <div class="media-body">
                                <div class="media-header">
                                    <strong>Ecinsa</strong>
    Alejandro Mart&iacute;n
    </div>
                                <div class="text-muted">
                                    <small>Hace 20 dias</small>
                                </div>
                            </div>
                        </div>
                        <div class="media">
                            <div class="media-left">
                                <i class="fa fa-check-circle" style="color:green;" aria-hidden="true"></i>
                            </div>
                            <div class="media-body">
                                <div class="media-header">
                                    <strong>VASS</strong>
    Andr&eacute;s Plaza
    </div>
                                <div class="text-muted">
                                    <small>Hace 23 dias</small>
                                </div>
                            </div>
                        </div>
                        <div class="media">
                            <div class="media-left">
                                <i class="fa fa-check-circle" style="color:green;" aria-hidden="true"></i>
                            </div>
                            <div class="media-body">
                                <div class="media-header">
                                    <strong>ICES</strong>
    H&eacute;ctor Riesco
    </div>
                                <div class="text-muted">
                                    <small>Hace 30 dias</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- FIN Widget Contratos activos -->   

            </div>
            <!-- FIN Contenedor widgets superior -->    

            <!-- INI Contenedor widgets inferior -->    
            <div class="widget-content">
                <!-- INI Widget Nuevas demandas --> 
                <div class="widget">
                    <!-- Header widget -->
                    <div class="widget-header">
                        <p class="title">Nuevas demandas</p>
                        <p class="title-items">
                            <a class="square" href="#">3</a>
                        </p>
                    </div>
                    <!-- Content widget -->
                    <div class="content-widget">
                        <div class="media">
                            <div class="media-left">
                                <i class="fa fa-caret-square-o-down" style="color:#FF800D"></i>
                            </div>
                            <div class="media-body">
                                <div class="media-header">
                                    <strong>Seguridad</strong>
    Empresas seguridad servidores
    </div>
                                <div class="text-muted">
                                    <small>Hace 5 dias</small>
                                </div>
                            </div>
                        </div>
                        <div class="media">
                            <div class="media-left">
                                <i class="fa fa-caret-square-o-down" style="color:#FF800D"></i>
                            </div>
                            <div class="media-body">
                                <div class="media-header">
                                    <strong>Programacion</strong>
    Python
                                </div>
                                <div class="text-muted">
                                    <small>Hace 7 dias</small>
                                </div>
                            </div>
                        </div>
                        <div class="media">
                            <div class="media-left">
                                <i class="fa fa-caret-square-o-down" style="color:#FF800D"></i>
                            </div>
                            <div class="media-body">
                                <div class="media-header">
                                    <strong>Administrador</strong>
    Servidores Linux
    </div>
                                <div class="text-muted">
                                    <small>Hace 10 dias</small>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- FIN Widget Nuevas demandas-->  

                <!-- INI Widget Dudas y sugerencias --> 
                <div class="widget">
                    <!-- Header widget -->
                    <div class="widget-header">
                        <p class="title">Dudas y sugerencias</p>
                        <p class="title-items">
                            <a class="square" href="#">10</a>
                        </p>
                    </div>
                    <!-- Content widget -->
                    <div class="content-widget">
                        <div class="media">
                            <div class="media-left">
                                <i class="fa fa-commenting-o" style="color:#B9264F"></i>    
                            </div>
                            <div class="media-body">
                                <div class="media-header">
                                    <strong>Luis</strong>
    Sugerencia seccion ofertas
    </div>
                                <div class="text-muted">
                                    <small>Hace 1 horas</small>
                                </div>
                            </div>
                        </div>
                        <div class="media">
                            <div class="media-left">
                                <i class="fa fa-commenting-o" style="color:#B9264F"></i>    
                            </div>
                            <div class="media-body">
                                <div class="media-header">
                                    <strong>Pedro</strong>
    Error acceso panel control
    </div>
                                <div class="text-muted">
                                    <small>Hace 3 horas</small>
                                </div>
                            </div>
                        </div>
                        <div class="media">
                            <div class="media-left">
                                <i class="fa fa-commenting-o" style="color:#B9264F"></i>    
                            </div>
                            <div class="media-body">
                                <div class="media-header">
                                    <strong>Lucia</strong>
    Error login usuario
    </div>
                                <div class="text-muted">
                                    <small>Hace 20 horas</small>
                                </div>
                            </div>
                        </div>
                        <div class="media">
                            <div class="media-left">
                                <i class="fa fa-commenting-o" style="color:#B9264F"></i>    
                            </div>
                            <div class="media-body">
                                <div class="media-header">
                                    <strong>Esther</strong>
    Sugerencia buzon de comentarios
    </div>
                                <div class="text-muted">
                                    <small>Hace 1 dia</small>
                                </div>
                            </div>
                        </div>
                        <div class="media">
                            <div class="media-left">
                                <i class="fa fa-commenting-o" style="color:#B9264F"></i>    
                            </div>
                            <div class="media-body">
                                <div class="media-header">
                                    <strong>Jaime</strong>
    Duda con empresa Ubisoft
    </div>
                                <div class="text-muted">
                                    <small>Hace 3 dias</small>
                                </div>
                            </div>
                        </div>
                        <div class="media">
                            <div class="media-left">
                                <i class="fa fa-commenting-o" style="color:#B9264F"></i>    
                            </div>
                            <div class="media-body">
                                <div class="media-header">
                                    <strong>Enrique</strong>
    Horas laborales en CPL
    </div>
                                <div class="text-muted">
                                    <small>Hace 4 dias</small>
                                </div>
                            </div>
                        </div>
                        <div class="media">
                            <div class="media-left">
                                <i class="fa fa-commenting-o" style="color:#B9264F"></i>    
                            </div>
                            <div class="media-body">
                                <div class="media-header">
                                    <strong>Alejandro</strong>
    Problema con empresa CetMe
    </div>
                                <div class="text-muted">
                                    <small>Hace 10 dias</small>
                                </div>
                            </div>
                        </div>
                        <div class="media">
                            <div class="media-left">
                                <i class="fa fa-commenting-o" style="color:#B9264F"></i>    
                            </div>
                            <div class="media-body">
                                <div class="media-header">
                                    <strong>Silvia</strong>
    Sugerencia sobre diseño
    </div>
                                <div class="text-muted">
                                    <small>Hace 15 dias</small>
                                </div>
                            </div>
                        </div>
                        <div class="media">
                            <div class="media-left">
                                <i class="fa fa-commenting-o" style="color:#B9264F"></i>    
                            </div>
                            <div class="media-body">
                                <div class="media-header">
                                    <strong>Alberto</strong>
    Problema con boton Encuestas
    </div>
                                <div class="text-muted">
                                    <small>Hace 20 dias</small>
                                </div>
                            </div>
                        </div>
                        <div class="media">
                            <div class="media-left">
                                <i class="fa fa-commenting-o" style="color:#B9264F"></i>    
                            </div>
                            <div class="media-body">
                                <div class="media-header">
                                    <strong>Andrea</strong>
    Sugerencia sobre contratos
    </div>
                                <div class="text-muted">
                                    <small>Hace 1 mes</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- FIN Widget Dudas y sugerencias --> 

            </div>
            <!-- FIN Contenedor widgets inferior -->    
		</div>   
EOF;
        $contenido = $buscador . $ofertas . $widgets;

        return $contenido;
    }

    public function generaTitlebar()
    {
        return parent::generaTitlebarParam("Internprise Administracion");
    }

    public function generaOfertas(){
        $content = <<<EOF
        <div id="content-ofertas-ver" class="content">
        <div id="tabla-ofertas-ver" class="table-container">
           <div class="table-header"> Oferta de prácticas </div>
                <table class="admin-table">
                    <tr>
                        <td>Empresa</td>
                        <td>Intel</td>
                    </tr>
                    <tr>
                        <td>Puesto</td>
                        <td>Especialista IT</td>
                    </tr>
                    <tr>
                        <td>Sueldo</td>
                        <td>400€</td>
                    </tr>
                    <tr>
                        <td>Carrera</td>
                        <td><p>Grado Ingenieria Informática</p>
                            <p>Grado Ingenieria Software</p>
                            <p>Grado Ingenieria Computadores</p>
                    </tr>
                    <tr>
                        <td>Horas</td>
                        <td>20</td>
                    </tr>
                    <tr>
                        <td>Plazas</td>
                        <td>2</td>
                    </tr>
                    <tr>
                        <td>Duracion</td>
                        <td>6 meses</td>
                    </tr>
                    <tr>
                        <td>Disponibilidad</td>
                        <td>mañana</td>
                    </tr>
                    <tr>
                        <td>Funciones</td>
                        <td>Mantenimiento de la red y de las conexiones de la empresa, como a su vez dar soporte de ayuda a las diferentes
                            estructuras dentro de la red empresarial con sus colaboradores</td>
                    </tr>
                    <tr>
                        <td>Aptitudes</td>
                        <td><p>Ingles</p>
                            <p>Python</p>
                            <p>Estudiante</p>
                            <p>Linux</p>
                            <p>Red</p>
                            <p>Seguridad</p></td>
                    </tr>
                    <tr>
                        <td>Requisitos minimos</td>
                        <td><p>Estar en ultimo año de carrera</p>
                            <p>Nivel B2 de ingles</p>
                            <p>Conocimientos avanzados de PYTHON</p></td>

                    </tr>
                    <tr>
                        <td>Aconsejable</td>
                        <td><p>Buen manejo con sistema operativo Linux</p>
                            <p>Facilidad para trabajar en grupo</p>
                            <p>Conocimientos basicos de protocolos de red</p></td>
                    </tr>
                    <tr>
                        <td colspan =2>
                        <button type="submit">Aceptar</button>
                        <button type="submit">Rechazar</button>
                        </td>
                    </tr>
                </table>
        </div>
    </div>
EOF;
        return $content;

    }
}