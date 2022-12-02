<template>
<div style=" background:#FFFFff; margin-top:-50px;  padding: 0px 30px; margin-left:-60px; transform:scale(0.9); position:relative; width:1188px;  font-family: 'Ubuntu', sans-serif;" >
    <!-- <pre>{{ datos }}</pre> -->
    <div style="position: relative;
        top: 0;
        left: -10;
        rigth: 0;
        height: 150px;
        /* background:pink; */
        width:100%;
        /* background: pink; */
        color: Black;
        font-family: 'Ubuntu', sans-serif;
        text-align: center;">
        <table>
            <tr style="">
                <td valgin="top">
                    <div style="width:270px; text-align:left;">
                        <span style="font-size:13pt; stroke:#000000; ">Universidad Nacional del Altiplano</span>
                        <span style="font-size:10pt;">Comisión de Inventario Activos Fijos 2022</span>
                    </div>
                </td>
                <td align="center">
                    <div style=" width:540px; margin-top:50px;">
                        <div><span style="font-size:14pt;"> FORMATO DE FICHA DE LEVANTAMIENTO DE INFORMACIÓN </span></div>
                        <span style="text-align:center; font-size:11pt;">INVENTARIO PATRIMONIAL 2022</span>
                    </div>
                </td>
                <td>
                    <div style="width: 270px;">
                        <span></span>
                    </div>
                </td>
            </tr>
         </table>
         <div style="height: 10px; width:100%;">
            <span></span>
         </div>
         <div>
         <table style="width:100%;">
            <tr>
                <td align="left">
                    <div style="width:188px;">
                        Dependencia
                    </div>
                </td>
                <td style=" width: 550px;" >
                    <div style="text-align: left"> <span>: {{datos.oficina.nombre}} - {{datos.oficina.dependencia}} </span> </div>
                </td>
                <td align="right" >
                    <div style="  margin-right:0cm; ">
                        <span>ID: {{datos.oficina.iduoper}}-{{datos.responsable.dni}}-1</span>
                    </div>
                </td>
            </tr>
            <tr>
                <td align="left">
                    <span>[DNI]Apellidos y Nombres</span>
                </td>
                <td style=" width: 300px; ">
                    <div style="text-align: left">
                            <span>: [ {{ datos.responsable.dni }} ] {{ datos.responsable.paterno }} {{ datos.responsable.materno }} {{ datos.responsable.nombres }} </span>
                    </div>
                </td>
                <td style="" align="right">
                    <div>
                        <span style="margin-right:0.5cm;">TIPO DE VERIFICACIÓN:</span><span style="margin-right:0.5cm;" > FÍSICA ( X ) </span> <span> DIGITAL ( &nbsp; ) </span>                         
                    </div>
                </td>
            </tr>

           </table>
        </div>
        <div>
        </div>
    </div>
    <div style="height: 5px">
        <span></span>
    </div>
    <div style="font-size:10pt; ">
    <table style="width: 100%; border-collapse: collapse; ">
        <thead>
        <tr>
            <th rowspan="2" align="center" style="border: solid 1px black; background: #cdcdcd4D; stroke:#000000; ">
                <div><span style="font-size: 9pt; font-weight:bold;">N° de</span> </div><div> <span style="font-size: 9pt; font-weight:bold;">Orden</span> </div></th>
            <th colspan="11" style="border: solid 1px black; background: #cdcdcd4D;">
                <span style="font-size: 9pt; font-weight:bold;">DESCRIPCION</span>
                
            </th>
        </tr>
        <tr align="center">
            <th style="border: solid 1px black; background: #cdcdcd4D;"> <span style="font-size: 9pt; font-weight:bold;"> Código </span> </th>
            <th style="border: solid 1px black; background: #cdcdcd4D;"> <span style="font-size: 9pt; font-weight:bold;">Denominación</span> </th>
            <th style="border: solid 1px black; background: #cdcdcd4D;"> <span style="font-size: 9pt; font-weight:bold;">Marca</span> </th>
            <th style="border: solid 1px black; background: #cdcdcd4D;"> <span style="font-size: 9pt; font-weight:bold;">Modelo</span> </th>
            <th style="border: solid 1px black; background: #cdcdcd4D;"> <span style="font-size: 9pt; font-weight:bold;">Tipo</span> </th>
            <th style="border: solid 1px black; background: #cdcdcd4D;"> <span style="font-size: 9pt; font-weight:bold;">Color</span> </th>
            <th style="border: solid 1px black; background: #cdcdcd4D;"> <span style="font-size: 9pt; font-weight:bold;">Serie</span> </th>
            <th style="border: solid 1px black; background: #cdcdcd4D;"> <span style="font-size: 9pt; font-weight:bold;">Dimensiones</span> </th>
            <th style="border: solid 1px black; background: #cdcdcd4D;"> <span style="font-size: 9pt; font-weight:bold;">Situación</span> </th>
            <th style="border: solid 1px black; background: #cdcdcd4D;"> <span style="font-size: 9pt; font-weight:bold;">Est</span> </th>
            <th style="border: solid 1px black; background: #cdcdcd4D;"> <span style="font-size: 9pt; font-weight:bold;">Observación</span> </th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(bien,index) in datos.bienes" :key="bien.id">
            <td align="center" v-if="bien.tipo === 'ACTIVO FIJO'" style="border:  solid 1px black;"><span style="font-size: 8pt; stroke:#000000; font-weight:bold;">{{index+1}}</span></td>
            <td align="center" v-else style="border: solid 1px black;"><span style="font-size: 8pt;"> {{index+1}}</span></td>
            <td v-if="bien.tipo === 'ACTIVO FIJO'" style="border: solid 1px black;"><span style="font-size: 8pt; font-weight: bold;">{{bien.codigo}}</span></td>
            <td v-else style="border: solid 1px black;"><span style="font-size: 8pt;">{{bien.codigo}}</span></td>
            <td v-if="bien.tipo === 'ACTIVO FIJO'" style="border: solid 1px black;"><span style="font-size: 8pt; font-weight: bold;">{{bien.descripcion}}</span></td>
            <td v-else style="border: solid 1px black;"><span style="font-size: 8pt; ">{{bien.descripcion}}</span></td>
            <td v-if="bien.tipo === 'ACTIVO FIJO'" style="border: solid 1px black;"><span style="font-size: 8pt; font-weight: bold;">{{bien.marca}}</span></td>
            <td v-else style="border: solid 1px black;"><span style="font-size: 8pt;  ">{{bien.marca}}</span></td>
            <td v-if="bien.tipo === 'ACTIVO FIJO'" style="border: solid 1px black;"><span style="font-size: 8pt; font-weight: bold;">{{bien.modelo}}</span></td>
            <td v-else style="border: solid 1px black;"><span style="font-size: 8pt;">{{bien.modelo}}</span></td>
            <td v-if="bien.tipo === 'ACTIVO FIJO'" style="border: solid 1px black;"><span style="font-size: 8pt; font-weight: bold;"></span></td>
            <td v-else style="border: solid 1px black;"><span style="font-size: 8pt;  "></span></td>
            <td v-if="bien.tipo === 'ACTIVO FIJO'" style="border: solid 1px black;"><span style="font-size: 8pt; font-weight: bold;">{{bien.color}}</span></td>
            <td v-else style="border: solid 1px black;"><span style="font-size: 8pt;">{{bien.color}}</span></td>
            <td v-if="bien.tipo === 'ACTIVO FIJO'" style="border: solid 1px black;"><span style="font-size: 8pt; font-weight: bold;">{{bien.nro_serie}}</span></td>
            <td v-else style="border: solid 1px black;"><span style="font-size: 8pt;">{{bien.nro_serie}}</span></td>
            <td v-if="bien.tipo === 'ACTIVO FIJO'" style="border: solid 1px black;"><span style="font-size: 8pt; font-weight: bold;">{{bien.medidas}}</span></td>
            <td v-else style="border: solid 1px black;"><span style="font-size: 8pt;">{{bien.medidas}}</span></td>

            <td v-if="bien.tipo === 'ACTIVO FIJO'" style="border: solid 1px black;" align="center"><span v-if="bien.estado_uso === 'EN USO'" style="font-weight: bold; font-size: 8pt;">U</span><span v-else style="font-weight: bold; font-size: 8pt;">D</span></td>
            <td v-else style="border: solid 1px black;" align="center"><span v-if="bien.estado_uso === 'EN USO'" style="font-size: 8pt;">U</span><span v-else style="font-size: 8pt;">U</span></td>

            <td v-if="bien.tipo === 'ACTIVO FIJO'" style="border: solid 1px black;" align="center">
                <span v-if="bien.id_estado == 1" style="font-size: 8pt; font-weight: bold;">B</span> 
                <span v-if="bien.id_estado == 2" style="font-size: 8pt; font-weight: bold;">R</span>
                <span v-if="bien.id_estado == 3" style="font-size: 8pt; font-weight: bold;">B</span>
                <span v-if="bien.id_estado == 4" style="font-size: 8pt; font-weight: bold;">M</span>
                <span v-if="bien.id_estado == 5" style="font-size: 8pt; font-weight: bold;">Y</span>
            </td>
            <td v-else style="border: solid 1px black;" align="center">
                <span v-if="bien.id_estado == 5" style="font-size: 8pt;">B</span>
                <span v-if="bien.id_estado == 4" style="font-size: 8pt;">R</span>
                <span v-if="bien.id_estado == 3" style="font-size: 8pt;">B</span>
                <span v-if="bien.id_estado == 2" style="font-size: 8pt;">M</span>
                <span v-if="bien.id_estado == 1" style="font-size: 8pt;">Y</span>
            </td>

            <td v-if="bien.tipo === 'ACTIVO FIJO'" style="border: solid 1px black;"><span style="font-weight: bold; font-size: 8pt;">{{ bien.observaciones }}</span></td>
            <td v-else style="border: solid 1px black;"><span style="font-size: 8pt;">{{ bien.observaciones }}</span></td>
        </tr>

        </tbody>
         <tr>
            <td  style="border: solid 1px black;" colspan="12">
            <div style="padding-top: 15px; padding-bottom: 25px;">
                <div>
                    <span style="font-size: 9pt;">Inventariador(es):</span>
                </div>
                <div v-for="inventarista in datos.inventaristas" :key="inventarista.id">
                    <div style="font-size: 9pt;"> - {{ inventarista.nombres }} {{ inventarista.apellidos }} </div>
                </div>
            </div>
            </td>
        </tr>
        <tr>
            <td colspan="12">
                <span style="font-size: 9pt;">Fecha y Hora: {{datos.lfecha}} {{datos.lhour}}</span>
            </td>
        </tr>
        <tr>
            <td colspan="12">
                <div>
                    <span style="font-size:9pt; letter-spacing: -0.1pt; ">(1) Uso (U). Desuso(D)</span>
                </div>
                <div>
                    <span style="font-size:9pt; letter-spacing: -0.1pt; ">(2) El estado consignado en base a la siguiente escala: Bueno, Regular, Malo, Chatarra y RAEE. En caso de semovientes utilizar escala de acuerdo a su naturaleza</span>
                </div>
            </td>
        </tr>
    </table>
    </div>
    <div
        style="
        margin-top: 180px;
        position:relative;
        height: 220px;
        /* background-color: #46c66b; */
        color: black;
        text-align: center;">
        <table style="width: 100%">
            <table>

                <td valign="top" colspan="4">
                    <div style="text-align:justify; font-size:8pt; width:100%; padding-top:5px;  letter-spacing: -0.06pt;">
                       <span><ins style=" font-weight:bold;"> CONSIDERACIONES: </ins></span> 
                    </div>
                    <div style="text-align:justify; font-size:8pt; width:100%; padding-top:5px;  letter-spacing: -0.06pt;">
                        <div >
                            <div style="display:flex;">
                                <div style="margin-right:7px;"><span>- </span></div>
                                <div>
                                    <span>El usuario declara haber mostrado todos los bienes muebles que se encuentran bajo su responsabilidad y no contar con más bienes muebles materia de inventario.</span>
                                </div>
                            </div>
                            <div style="display:flex;">
                                <div style="margin-right:7px;"><span>- </span></div>
                                <div>
                                    <span>El usuario es responsable de la permanencia y conservación de cada uno de los bienes muebles dscritos, recomendánse tomar las precausiones del caso para evitar sustracciones deteriodos, etc.</span>
                                </div>
                            </div>
                            <div style="display:flex;">
                                <div style="margin-right:7px;"><span>- </span></div>
                                <div>
                                    <span>Cualquier necesidad de traslado del bien mueble dentro o fuera del local de la Entidad u Organización de la Entidad, es previamente comunicado al encargado de la OCP.</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </td>
            </table>
        </table>
        <table style="width: 100%">
            <tr>
                <td align="center">
                    <div style=" margin-top: 50px; padding: 0 30px; margin-left:20px; ">
                        <div style="text-align: center; padding-top: 5px; width:280px; border-top: solid 0.5px black;">
                            <span style="font-size:10pt;">JEFE INMEDIATO SUPERIOR</span>
                        </div>
                        <dir style="margin-top:0px; margin-left:125px; text-align:left; ">
                            <span style="font-size:10pt;">DNI:</span>
                        </dir>
                    </div>
                </td>

                <td align="center">
                    <div style=" margin-top: 50px; padding: 0 0px;">
                        <div style="text-align: center; padding-top: 5px; width:280px; border-top: solid 0.5px black;">
                            <span style="font-size:10pt;">RESPONSABLE DE LOS BIENES</span>
                        </div>
                        <dir style="margin-top:0px; text-align:left; margin-left:95px; ">
                            <span style="font-size:10pt;">DNI:</span>
                        </dir>
                    </div>
                </td>

                <td align="center">
                    <div style=" margin-top: 50px; padding: 0 0px;">
                        <div style="text-align: center; width:280px; padding-top: 5px; border-top: solid 0.5px black;">
                            <span style="font-size:10pt;">INVENTARIADOR(ES)</span>
                        </div>
                        <dir style="margin-top:0px; text-align:left; margin-left:5px;  ">
                            <span style="font-size:10pt;"> &nbsp; </span>
                        </dir>
                    </div>
                </td>

            </tr>
        </table>
    </div>
    <div style=" position:absolute; bottom:-50px; margin-left:-60px; width:120%; height:70px; background:#ffffff;">

    </div>
</div>

</template>
<script >
    export default {
        props: ['datos'],
        props: {
            datos: Object
        },
    }

// if ( isset($pdf) ) {
//     $pdf->page_script('
//         $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
//         $pdf->text(775, 20, "Pág $PAGE_NUM / $PAGE_COUNT", $font, 10);
//     ');
// }
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap');
*{
    margin:0cm 0cm;
    padding: 0cm 0cm;
    font-size: 11pt;
    font-weight: 400;
    font-family: 'Ubuntu', sans-serif;
}
</style>
