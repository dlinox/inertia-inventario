<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsuariosDemo extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'nombres' => 'Denis',
            'apellidos' => 'Puma Ticona',
            'rol' => 1,
            'estado' => 1,
            'email' => 'nearlino20@gmail.com',
            'password' => Hash::make('demo'),
        ])->assignRole('Administrador');


        User::create([
            'nombres' => 'Aministrador',
            'apellidos' => 'Puma Ticona',
            'rol' => 1,
            'estado' => 1,
            'email' => 'nearlino20@gmail.com',
            'password' => Hash::make('demo'),
        ])->assignRole('Administrador');


        User::create([
            'nombres' => 'Ariel',
            'apellidos' => 'Luque Cusacani',
            'rol' => 1,
            'estado' => 1,
            'email' => 'jhonar.theking@gmail.com',
            'password' => Hash::make('demo'),
        ])->assignRole('Administrador');

        User::create(['nombres' => 'ARNOL ALONSO', 'apellidos'=>'AGUILAR LIMA','rol'=>2,'estado'=>1,'email'=>'al_arnol@invunap2022.net', 'password'=>Hash::make('aguilarla'), ])->assignRole('Inventario');
        User::create(['nombres' => 'MIRIAN GLADYS', 'apellidos'=>'ALVAREZ TORRES','rol'=>2,'estado'=>1,'email'=>'at_mirian@invunap2022.net', 'password'=>Hash::make('alvareztm'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'JAVIER EMERSON', 'apellidos'=>'APAZA CHOQUEHUANCA','rol'=>2,'estado'=>1,'email'=>'ac_javier@invunap2022.net', 'password'=>Hash::make('apazacj'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'DAYMIR ', 'apellidos'=>'APAZA FLORES','rol'=>2,'estado'=>1,'email'=>'af_daymir@invunap2022.net', 'password'=>Hash::make('apazafd'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'GUISELA ', 'apellidos'=>'ARI COSI','rol'=>2,'estado'=>1,'email'=>'ac_guisela@invunap2022.net', 'password'=>Hash::make('aricg'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'ROBERT MAX', 'apellidos'=>'QUISPE QUISPE','rol'=>2,'estado'=>1,'email'=>'qq_robert@invunap2022.net', 'password'=>Hash::make('quispeqr'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'DAVY THOMSON', 'apellidos'=>'CALLERI CAXI','rol'=>2,'estado'=>1,'email'=>'cc_davy@invunap2022.net', 'password'=>Hash::make('callericd'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'GABRIELA YAMELIT', 'apellidos'=>'BALCONA CCAMA','rol'=>2,'estado'=>1,'email'=>'bc_gabriela@invunap2022.net', 'password'=>Hash::make('balconacg'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'ESTHER ', 'apellidos'=>'BARREDA ARPI','rol'=>2,'estado'=>1,'email'=>'ba_esther@invunap2022.net', 'password'=>Hash::make('barredaae'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'RENATO JORDAN', 'apellidos'=>'BENTACUR MAMAMNI','rol'=>2,'estado'=>1,'email'=>'bm_renato@invunap2022.net', 'password'=>Hash::make('bentacurmr'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'MYUMI AMERICA', 'apellidos'=>'BORDA VARGAS','rol'=>2,'estado'=>1,'email'=>'bv_myumi@invunap2022.net', 'password'=>Hash::make('bordavm'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'YOVANA YORKA', 'apellidos'=>'CACERES CHOQUE','rol'=>2,'estado'=>1,'email'=>'cc_yovana@invunap2022.net', 'password'=>Hash::make('cacerescy'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'MARILIN ', 'apellidos'=>'MENDOZA QUISPE','rol'=>2,'estado'=>1,'email'=>'mq_marilin@invunap2022.net', 'password'=>Hash::make('mendozaqm'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'CARLOS ALBERTO', 'apellidos'=>'CHOQUE MAMANI','rol'=>2,'estado'=>1,'email'=>'cm_carlos@invunap2022.net', 'password'=>Hash::make('choquemc'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'JULIETA CATERINE', 'apellidos'=>'FERNANDEZ BLAS','rol'=>2,'estado'=>1,'email'=>'fb_julieta@invunap2022.net', 'password'=>Hash::make('fernandezbj'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'CINTYA OLENKA', 'apellidos'=>'CHOQUE MOLLOCONDO','rol'=>2,'estado'=>1,'email'=>'cm_cintya@invunap2022.net', 'password'=>Hash::make('choquemc'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'SUSSY ', 'apellidos'=>'CHOQUEMALLCO TICONA','rol'=>2,'estado'=>1,'email'=>'ct_sussy@invunap2022.net', 'password'=>Hash::make('choquemallcots'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'ELIZABETH FLORA', 'apellidos'=>'CONDORI LLANOS','rol'=>2,'estado'=>1,'email'=>'cl_elizabeth@invunap2022.net', 'password'=>Hash::make('condorile'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'HERDER WILDO', 'apellidos'=>'COSI QUISPE','rol'=>2,'estado'=>1,'email'=>'cq_herder@invunap2022.net', 'password'=>Hash::make('cosiqh'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'ROCIO MARITZA', 'apellidos'=>'MAMANI LIZAMA','rol'=>2,'estado'=>1,'email'=>'ml_rocio@invunap2022.net', 'password'=>Hash::make('mamanilr'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'FERNANDO ', 'apellidos'=>'DUEÑAS RUELAS','rol'=>2,'estado'=>1,'email'=>'dr_fernando@invunap2022.net', 'password'=>Hash::make('dueñasrf'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'LEYDI PATRICIA', 'apellidos'=>'GALLEGOS GORDILLO','rol'=>2,'estado'=>1,'email'=>'gg_leydi@invunap2022.net', 'password'=>Hash::make('gallegosgl'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'LOURDES ', 'apellidos'=>'GALLEGOS RUELAS','rol'=>2,'estado'=>1,'email'=>'gr_lourdes@invunap2022.net', 'password'=>Hash::make('gallegosrl'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'LENIN ', 'apellidos'=>'GONZALES HERRERA','rol'=>2,'estado'=>1,'email'=>'gh_lenin@invunap2022.net', 'password'=>Hash::make('gonzaleshl'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'YELKA NAIRIBI', 'apellidos'=>'GUTIERREZ EDUARDO','rol'=>2,'estado'=>1,'email'=>'ge_yelka@invunap2022.net', 'password'=>Hash::make('gutierrezey'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'GISELA ', 'apellidos'=>'HUACANI MAMANI','rol'=>2,'estado'=>1,'email'=>'hm_gisela@invunap2022.net', 'password'=>Hash::make('huacanimg'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'ANALY ', 'apellidos'=>'RODRIGUEZ GOMEZ','rol'=>2,'estado'=>1,'email'=>'rg_analy@invunap2022.net', 'password'=>Hash::make('rodriguezga'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'GROBER ', 'apellidos'=>'RUELAS VELARDE','rol'=>2,'estado'=>1,'email'=>'rv_grober@invunap2022.net', 'password'=>Hash::make('ruelasvg'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'BERTHA MAKSELY', 'apellidos'=>'ILLACUTIPA CALCINA','rol'=>2,'estado'=>1,'email'=>'ic_bertha@invunap2022.net', 'password'=>Hash::make('illacutipacb'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'EDITH ', 'apellidos'=>'ISIDRO CHAGUA','rol'=>2,'estado'=>1,'email'=>'ic_edith@invunap2022.net', 'password'=>Hash::make('isidroce'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'TANIA MISYUMI', 'apellidos'=>'LIMA LIMA','rol'=>2,'estado'=>1,'email'=>'ll_tania@invunap2022.net', 'password'=>Hash::make('limalt'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'SHAROM EMPERATRIZ', 'apellidos'=>'LUQUE LIRA','rol'=>2,'estado'=>1,'email'=>'ll_sharom@invunap2022.net', 'password'=>Hash::make('luquels'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'RAFHAEL JOEL', 'apellidos'=>'VARGAS RAMOS','rol'=>2,'estado'=>1,'email'=>'vr_rafhael@invunap2022.net', 'password'=>Hash::make('vargasrr'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'MIGUEL ALEXANDER', 'apellidos'=>'MEDINA SANTANDER','rol'=>2,'estado'=>1,'email'=>'ms_miguel@invunap2022.net', 'password'=>Hash::make('medinasm'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'YULIBETH CARMEN', 'apellidos'=>'TICONA FLORES','rol'=>2,'estado'=>1,'email'=>'tf_yulibeth@invunap2022.net', 'password'=>Hash::make('ticonafy'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'ALBERT ', 'apellidos'=>'RAMOS QUISPE','rol'=>2,'estado'=>1,'email'=>'rq_albert@invunap2022.net', 'password'=>Hash::make('ramosqa'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'IBETH GUADALUPE', 'apellidos'=>'HUANCAPAZA CANAZA','rol'=>2,'estado'=>1,'email'=>'hc_ibeth@invunap2022.net', 'password'=>Hash::make('huancapazaci'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'JHON ARIEL', 'apellidos'=>'LUQUE CUSACANI','rol'=>2,'estado'=>1,'email'=>'lc_jhon@invunap2022.net', 'password'=>Hash::make('luquecj'),  ])->assignRole('Inventario');
        User::create(['nombres' => 'DENIS LINO', 'apellidos'=>'PUMA TICONA','rol'=>2,'estado'=>1,'email'=>'pt_denis@invunap2022.net', 'password'=>Hash::make('pumatd'),  ])->assignRole('Inventario');
    







    }
}
