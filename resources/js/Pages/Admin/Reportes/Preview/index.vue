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
                        <span style="font-size:13pt; stroke:#000000; ">Universidad Nacional de Altiplano</span>
                        <span style="font-size:10pt;">Comisión de Inventario Activos Fijos 2022</span>
                    </div>
                </td>
                <td align="center">
                    <div style=" width:540px; margin-top:50px;">
                        <div><span style="font-size:14pt;"> INVENTARIO PATRIMONIAL 2022 </span></div>
                        <span style="text-align:center; font-size:11pt;">FORMATO DE TOMA DE INVENTARIO DE BIENES MUEBLES Y EQUIPOS</span>
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
                <td style=" width: 650px;" >
                    <div style="text-align: left"> <span>: {{datos.area.nombre}} - {{datos.oficina.nombre}}  </span> </div>
                </td>
                <td align="right">
                    <div style=" width:188px; margin-right:.5cm; ">
                        <span>ID: 61.54.1-42262469-1</span>
                    </div>
                </td>
            </tr>
            <tr>
                <td align="left">
                    <span>[DNI]Apellidos y Nombres</span>
                </td>
                <td style=" width: 100%">
                    <div style="text-align: left">
                            <span>: [ {{ datos.responsable.dni }} ] {{ datos.responsable.paterno }} {{ datos.responsable.materno }} {{ datos.responsable.nombres }} </span>
                    </div>
                </td>
                <td>
                    <div >
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
        <thead >
        <tr align="center">
            <th>Nro</th>
            <th>Código</th>
            <th>Descripción de Mueble ó Equipo</th>
            <th>Modelo</th>
            <th>Marca</th>
            <th>Serie</th>
            <th>Medida*</th>
            <th>Color</th>
            <th>Est**</th>
            <th>Item</th>
            <th>Observaciones</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(bien,index) in datos.bienes" :key="bien.id">
            <td align="center" v-if="bien.tipo === '3'" style="border:  solid 1px black;"><span style="font-size: 8pt; stroke:#000000; font-weight:bold;">{{index+1}}</span></td>
            <td align="center" v-else style="border: solid 1px black;"><span style="font-size: 8pt;"> {{index+1}}</span></td>
            <td v-if="bien.tipo === '3'" style="border: solid 1px black;"><span style="font-size: 8pt; font-weight: bold;">{{bien.codigo}}</span></td>
            <td v-else style="border: solid 1px black;"><span style="font-size: 8pt;">{{bien.codigo}}</span></td>
            <td v-if="bien.tipo === '3'" style="border: solid 1px black;"><span style="font-size: 8pt; font-weight: bold;">{{bien.nombre}}</span></td>
            <td v-else style="border: solid 1px black;"><span style="font-size: 8pt; ">{{bien.nombre}}</span></td>
            <td v-if="bien.tipo === '3'" style="border: solid 1px black;"><span style="font-size: 8pt; font-weight: bold;">{{bien.modelo}}</span></td>
            <td v-else style="border: solid 1px black;"><span style="font-size: 8pt;">{{bien.modelo}}</span></td>
            <td v-if="bien.tipo === '3'" style="border: solid 1px black;"><span style="font-size: 8pt; font-weight: bold;">{{bien.marca}}</span></td>
            <td v-else style="border: solid 1px black;"><span style="font-size: 8pt;  ">{{bien.marca}}</span></td>
            <td v-if="bien.tipo === '3'" style="border: solid 1px black;"><span style="font-size: 8pt; font-weight: bold;">{{bien.serie}}</span></td>
            <td v-else style="border: solid 1px black;"><span style="font-size: 8pt;">{{bien.serie}}</span></td>
            <td v-if="bien.tipo === '3'" style="border: solid 1px black;"><span style="font-size: 8pt; font-weight: bold;"></span></td>
            <td v-else style="border: solid 1px black;"><span style="font-size: 8pt;"></span></td>
            <td v-if="bien.tipo === '3'" style="border: solid 1px black;"><span style="font-size: 8pt; font-weight: bold;">NEGRO</span></td>
            <td v-else style="border: solid 1px black;"><span style="font-size: 8pt;">NEGRO</span></td>
            <td v-if="bien.tipo === '3'" style="border: solid 1px black;">
                <span v-if="bien.id_estado == 5" style="font-size: 8pt; font-weight: bold; ">N</span>
                <span v-if="bien.id_estado == 4" style="font-size: 8pt; font-weight: bold;">B</span>
                <span v-if="bien.id_estado == 3" style="font-size: 8pt; font-weight: bold;" >R</span>
                <span v-if="bien.id_estado == 2" style="font-size: 8pt; font-weight: bold;">M</span>
                <span v-if="bien.id_estado == 1" style="font-size: 8pt; font-weight: bold;">Y</span>
            </td>
            <td v-else style="border: solid 1px black;">
                <span v-if="bien.id_estado == 5" style="font-size: 8pt;">N</span>
                <span v-if="bien.id_estado == 4" style="font-size: 8pt;">B</span>
                <span v-if="bien.id_estado == 3" style="font-size: 8pt;" >R</span>
                <span v-if="bien.id_estado == 2" style="font-size: 8pt;">M</span>
                <span v-if="bien.id_estado == 1" style="font-size: 8pt;">Y</span>
            </td>
            <td v-if="bien.tipo === '3'" style="border: solid 1px black;"><span style="font-weight: bold; font-size: 8pt;">{{bien.numero}}</span></td>
            <td v-else style="border: solid 1px black;"><span style="font-size: 8pt;">{{bien.numero}}</span></td>
            <td v-if="bien.tipo === '3'" style="border: solid 1px black;"><span style="font-weight: bold; font-size: 8pt;">{{ bien.observaciones }}</span></td>
            <td v-else style="border: solid 1px black;"><span style="font-size: 8pt;">{{ bien.observaciones }}</span></td>
        </tr>

        </tbody>
         <tr>
            <td  style="border: solid 1px black;" colspan="11">
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
            <td colspan="11">
                <span style="font-size: 9pt;">Fecha y Hora: {{datos.lfecha}} {{datos.lhour}}</span>
            </td>
        </tr>
    </table>
    </div>
    <div
        style="
        margin-top: 200px;
        position:relative;
        height: 160px;
        /* background-color: #46c66b; */
        color: black;
        text-align: center;">
        <table style="width: 100%">
            <table>
                <td valign="top"><span style="font-size: 8pt; width:20px;">NOTA:</span> </td>
                <td valign="top" colspan="3">
                    <div style="text-align:justify; font-size:8pt; width:100%; padding-top:5px;  letter-spacing: -0.06pt;">
                        EL TRABAJADOR ES RESPONSABLE DIRECTO DE LAS EXISTENCIAS, PERMANENCIA, CONSERVACIÓN Y BUEN USO DE CADA UNO DE LOS BIENES DESCRITOS POR LO QUE SE RECOMIENDA TOMAR
                        LAS PROVIDENCIASA DEL CASO PARA EVITAR PERDIDAS, SUSTRACCION, DETERIODO, ETC., EN CASO DE CUALQUIER MOVIMIENTO DENTRO O FUERA DE LA ENTIDAD DEBERA SER COMUNICADO AL
                        ENCARGO DE CONTROL PATRIMONIAL, BAJO RESPONSABILIDAD.
                        <span style="font-size:8pt; letter-spacing: -0.1pt; margin-left: 567px; margin-right:20px;">*Medida: Largo x Ancho x Altura </span>
                        <span style="font-size:8pt; letter-spacing: -0.1pt;">**Estado:(N)Nuevo, (R)Regular, (M)Malo, (Y) Chatarra</span>
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
