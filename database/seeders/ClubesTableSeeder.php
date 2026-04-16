<?php   
namespace Database\Seeders;
       
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClubesTableSeeder extends Seeder
{
    public function run()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0');
        \DB::table('clubes')->delete();

        \DB::table('clubes')->insert(array(
            //Argentina
            0 => array('id_club'=>'189','slug_club'=>'club-atletico-boca-juniors','nombre_club'=>'CA Boca Juniors','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/189.png?lm=1511621129','pais_club'=>'Argentina','id_liga_club'=>'ARGC','dificultad_club'=>'3'),
            1 => array('id_club'=>'209','slug_club'=>'club-atletico-river-plate','nombre_club'=>'CA River Plate','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/209.png?lm=1645539487','pais_club'=>'Argentina','id_liga_club'=>'ARGC','dificultad_club'=>'3'),

            //Belgica
            2 => array('id_club'=>'2282','slug_club'=>'fc-brugge','nombre_club'=>'Club Brugge KV','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/2282.png?lm=1716279106','pais_club'=>'Belgium','id_liga_club'=>'BE1','dificultad_club'=>'2'),
            3 => array('id_club'=>'58','slug_club'=>'rsc-anderlecht','nombre_club'=>'RSC Anderlecht','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/58.png?lm=1718695206','pais_club'=>'Belgium','id_liga_club'=>'BE1','dificultad_club'=>'3'),

            //Brasil
            4 => array('id_club'=>'1023','slug_club'=>'se-palmeiras-sao-paulo','nombre_club'=>'Sociedade Esportiva Palmeiras','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/1023.png?lm=1411204983','pais_club'=>'Brazil','id_liga_club'=>'BRA1','dificultad_club'=>'3'),
            5 => array('id_club'=>'199','slug_club'=>'corinthians-sao-paulo','nombre_club'=>'Sport Club Corinthians Paulista','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/199.png?lm=1649430398','pais_club'=>'Brazil','id_liga_club'=>'BRA1','dificultad_club'=>'3'),
            6 => array('id_club'=>'210','slug_club'=>'gremio-porto-alegre','nombre_club'=>'Grêmio Foot-Ball Porto Alegrense','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/210.png?lm=1412879265','pais_club'=>'Brazil','id_liga_club'=>'BRA1','dificultad_club'=>'3'),
            7 => array('id_club'=>'221','slug_club'=>'fc-santos','nombre_club'=>'Santos FC','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/221.png?lm=1412879099','pais_club'=>'Brazil','id_liga_club'=>'BRA1','dificultad_club'=>'3'),
            8 => array('id_club'=>'2462','slug_club'=>'fluminense-rio-de-janeiro','nombre_club'=>'Fluminense Football Club','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/2462.png?lm=1648225934','pais_club'=>'Brazil','id_liga_club'=>'BRA1','dificultad_club'=>'3'),
            9 => array('id_club'=>'614','slug_club'=>'flamengo-rio-de-janeiro','nombre_club'=>'CR Flamengo','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/614.png?lm=1551023331','pais_club'=>'Brazil','id_liga_club'=>'BRA1','dificultad_club'=>'3'),

            //España
            10 => array('id_club'=>'1049','slug_club'=>'fc-valencia','nombre_club'=>'Valencia CF','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/1049.png?lm=1406966320','pais_club'=>'Spain','id_liga_club'=>'ES1','dificultad_club'=>'1'),
            11 => array('id_club'=>'1050','slug_club'=>'fc-villarreal','nombre_club'=>'Villarreal CF','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/1050.png?lm=1408655310','pais_club'=>'Spain','id_liga_club'=>'ES1','dificultad_club'=>'1'),
            12 => array('id_club'=>'1108','slug_club'=>'deportivo-alaves','nombre_club'=>'Deportivo Alavés','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/1108.png?lm=1596131395','pais_club'=>'Spain','id_liga_club'=>'ES1','dificultad_club'=>'1'),
            13 => array('id_club'=>'12321','slug_club'=>'fc-girona','nombre_club'=>'Girona FC','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/12321.png?lm=1730455718','pais_club'=>'Spain','id_liga_club'=>'ES1','dificultad_club'=>'1'),
            14 => array('id_club'=>'13','slug_club'=>'atletico-madrid','nombre_club'=>'Atlético de Madrid','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/13.png?lm=1719915566','pais_club'=>'Spain','id_liga_club'=>'ES1','dificultad_club'=>'1'),
            15 => array('id_club'=>'131','slug_club'=>'fc-barcelona','nombre_club'=>'FC Barcelona','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/131.png?lm=1406739548','pais_club'=>'Spain','id_liga_club'=>'ES1','dificultad_club'=>'1'),
            16 => array('id_club'=>'150','slug_club'=>'real-betis-sevilla','nombre_club'=>'Real Betis Balompié','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/150.png?lm=1663358526','pais_club'=>'Spain','id_liga_club'=>'ES1','dificultad_club'=>'1'),
            17 => array('id_club'=>'1531','slug_club'=>'fc-elche','nombre_club'=>'Elche CF','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/1531.png?lm=1421955260','pais_club'=>'Spain','id_liga_club'=>'ES1','dificultad_club'=>'1'),
            18 => array('id_club'=>'237','slug_club'=>'rcd-mallorca','nombre_club'=>'RCD Mallorca','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/237.png?lm=1407484750','pais_club'=>'Spain','id_liga_club'=>'ES1','dificultad_club'=>'1'),
            19 => array('id_club'=>'2497','slug_club'=>'real-oviedo','nombre_club'=>'Real Oviedo','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/2497.png?lm=1417193316','pais_club'=>'Spain','id_liga_club'=>'ES1','dificultad_club'=>'2'),
            20 => array('id_club'=>'331','slug_club'=>'ca-osasuna','nombre_club'=>'CA Osasuna','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/331.png?lm=1686070937','pais_club'=>'Spain','id_liga_club'=>'ES1','dificultad_club'=>'1'),
            21 => array('id_club'=>'3368','slug_club'=>'ud-levante','nombre_club'=>'Levante UD','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/3368.png?lm=1408655062','pais_club'=>'Spain','id_liga_club'=>'ES1','dificultad_club'=>'1'),
            22 => array('id_club'=>'367','slug_club'=>'rayo-vallecano','nombre_club'=>'Rayo Vallecano','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/367.png?lm=1653488445','pais_club'=>'Spain','id_liga_club'=>'ES1','dificultad_club'=>'1'),
            23 => array('id_club'=>'368','slug_club'=>'fc-sevilla','nombre_club'=>'Sevilla FC','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/368.png?lm=1730896593','pais_club'=>'Spain','id_liga_club'=>'ES1','dificultad_club'=>'1'),
            24 => array('id_club'=>'3709','slug_club'=>'fc-getafe','nombre_club'=>'Getafe CF','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/3709.png?lm=1408655116','pais_club'=>'Spain','id_liga_club'=>'ES1','dificultad_club'=>'1'),
            25 => array('id_club'=>'418','slug_club'=>'real-madrid','nombre_club'=>'Real Madrid','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/418.png?lm=1729684474','pais_club'=>'Spain','id_liga_club'=>'ES1','dificultad_club'=>'1'),
            26 => array('id_club'=>'621','slug_club'=>'athletic-bilbao','nombre_club'=>'Athletic Bilbao','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/621.png?lm=1695069038','pais_club'=>'Spain','id_liga_club'=>'ES1','dificultad_club'=>'1'),
            27 => array('id_club'=>'681','slug_club'=>'real-sociedad-san-sebastian','nombre_club'=>'Real Sociedad','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/681.png?lm=1614795530','pais_club'=>'Spain','id_liga_club'=>'ES1','dificultad_club'=>'1'),
            28 => array('id_club'=>'714','slug_club'=>'espanyol-barcelona','nombre_club'=>'RCD Espanyol Barcelona','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/714.png?lm=1406966369','pais_club'=>'Spain','id_liga_club'=>'ES1','dificultad_club'=>'1'),
            29 => array('id_club'=>'940','slug_club'=>'celta-vigo','nombre_club'=>'Celta de Vigo','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/940.png?lm=1406966406','pais_club'=>'Spain','id_liga_club'=>'ES1','dificultad_club'=>'1'),

            //Francia
            30 => array('id_club'=>'1041','slug_club'=>'olympique-lyon','nombre_club'=>'Olympique Lyon','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/1041.png?lm=1656668172','pais_club'=>'France','id_liga_club'=>'FR1','dificultad_club'=>'1'),
            31 => array('id_club'=>'1082','slug_club'=>'losc-lille','nombre_club'=>'LOSC Lille','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/1082.png?lm=1529521041','pais_club'=>'France','id_liga_club'=>'FR1','dificultad_club'=>'1'),
            32 => array('id_club'=>'162','slug_club'=>'as-monaco','nombre_club'=>'AS Monaco','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/162.png?lm=1654781919','pais_club'=>'Monaco','id_liga_club'=>'FR1','dificultad_club'=>'1'),
            33 => array('id_club'=>'244','slug_club'=>'olympique-marseille','nombre_club'=>'Olympique Marseille','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/244.png?lm=1485642163','pais_club'=>'France','id_liga_club'=>'FR1','dificultad_club'=>'1'),
            34 => array('id_club'=>'273','slug_club'=>'fc-stade-rennes','nombre_club'=>'Stade Rennais FC','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/273.png?lm=1691503972','pais_club'=>'France','id_liga_club'=>'FR1','dificultad_club'=>'2'),
            35 => array('id_club'=>'417','slug_club'=>'ogc-nizza','nombre_club'=>'OGC Nice','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/417.png?lm=1408779490','pais_club'=>'France','id_liga_club'=>'FR1','dificultad_club'=>'2'),
            36 => array('id_club'=>'583','slug_club'=>'fc-paris-saint-germain','nombre_club'=>'Paris Saint-Germain','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/583.png?lm=1728026461','pais_club'=>'France','id_liga_club'=>'FR1','dificultad_club'=>'1'),
            37 => array('id_club'=>'826','slug_club'=>'rc-lens','nombre_club'=>'RC Lens','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/826.png?lm=1595457059','pais_club'=>'France','id_liga_club'=>'FR1','dificultad_club'=>'2'),
            38 => array('id_club'=>'995','slug_club'=>'fc-nantes','nombre_club'=>'FC Nantes','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/995.png?lm=1581355747','pais_club'=>'France','id_liga_club'=>'FR1','dificultad_club'=>'2'),

            //Inglaterra
            39 => array('id_club'=>'11','slug_club'=>'fc-arsenal','nombre_club'=>'Arsenal FC','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/11.png?lm=1489787850','pais_club'=>'England','id_liga_club'=>'GB1','dificultad_club'=>'1'),
            40 => array('id_club'=>'1148','slug_club'=>'fc-brentford','nombre_club'=>'Brentford FC','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/1148.png?lm=1625150543','pais_club'=>'England','id_liga_club'=>'GB1','dificultad_club'=>'2'),
            41 => array('id_club'=>'1237','slug_club'=>'brighton-amp-hove-albion','nombre_club'=>'Brighton & Hove Albion','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/1237.png?lm=1492718902','pais_club'=>'England','id_liga_club'=>'GB1','dificultad_club'=>'2'),
            42 => array('id_club'=>'148','slug_club'=>'tottenham-hotspur','nombre_club'=>'Tottenham Hotspur','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/148.png?lm=1732011953','pais_club'=>'England','id_liga_club'=>'GB1','dificultad_club'=>'1'),
            43 => array('id_club'=>'281','slug_club'=>'manchester-city','nombre_club'=>'Manchester City','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/281.png?lm=1467356331','pais_club'=>'England','id_liga_club'=>'GB1','dificultad_club'=>'1'),
            44 => array('id_club'=>'29','slug_club'=>'fc-everton','nombre_club'=>'Everton FC','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/29.png?lm=1445949846','pais_club'=>'England','id_liga_club'=>'GB1','dificultad_club'=>'1'),
            45 => array('id_club'=>'31','slug_club'=>'fc-liverpool','nombre_club'=>'Liverpool FC','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/31.png?lm=1727873452','pais_club'=>'England','id_liga_club'=>'GB1','dificultad_club'=>'1'),
            46 => array('id_club'=>'379','slug_club'=>'west-ham-united','nombre_club'=>'West Ham United','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/379.png?lm=1464675260','pais_club'=>'England','id_liga_club'=>'GB1','dificultad_club'=>'1'),
            47 => array('id_club'=>'399','slug_club'=>'leeds-united','nombre_club'=>'Leeds United','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/399.png?lm=1645652224','pais_club'=>'England','id_liga_club'=>'GB1','dificultad_club'=>'1'),
            48 => array('id_club'=>'405','slug_club'=>'aston-villa','nombre_club'=>'Aston Villa','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/405.png?lm=1717155982','pais_club'=>'England','id_liga_club'=>'GB1','dificultad_club'=>'1'),
            49 => array('id_club'=>'543','slug_club'=>'wolverhampton-wanderers','nombre_club'=>'Wolverhampton Wanderers','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/543.png?lm=1467496784','pais_club'=>'England','id_liga_club'=>'GB1','dificultad_club'=>'1'),
            50 => array('id_club'=>'631','slug_club'=>'fc-chelsea','nombre_club'=>'Chelsea FC','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/631.png?lm=1682435911','pais_club'=>'England','id_liga_club'=>'GB1','dificultad_club'=>'1'),
            51 => array('id_club'=>'703','slug_club'=>'nottingham-forest','nombre_club'=>'Nottingham Forest','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/703.png?lm=1598890289','pais_club'=>'England','id_liga_club'=>'GB1','dificultad_club'=>'1'),
            52 => array('id_club'=>'762','slug_club'=>'newcastle-united','nombre_club'=>'Newcastle United','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/762.png?lm=1472921161','pais_club'=>'England','id_liga_club'=>'GB1','dificultad_club'=>'1'),
            53 => array('id_club'=>'873','slug_club'=>'crystal-palace','nombre_club'=>'Crystal Palace','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/873.png?lm=1457723287','pais_club'=>'England','id_liga_club'=>'GB1','dificultad_club'=>'1'),
            54 => array('id_club'=>'931','slug_club'=>'fc-fulham','nombre_club'=>'Fulham FC','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/931.png?lm=1556831687','pais_club'=>'England','id_liga_club'=>'GB1','dificultad_club'=>'2'),
            55 => array('id_club'=>'985','slug_club'=>'manchester-united','nombre_club'=>'Manchester United','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/985.png?lm=1457975903','pais_club'=>'England','id_liga_club'=>'GB1','dificultad_club'=>'1'),
            56 => array('id_club'=>'989','slug_club'=>'afc-bournemouth','nombre_club'=>'AFC Bournemouth','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/989.png?lm=1457991811','pais_club'=>'England','id_liga_club'=>'GB1','dificultad_club'=>'2'),

            // GRECIA
            57 => array('id_club'=>'265','slug_club'=>'panathinaikos-athen','nombre_club'=>'Panathinaikos FC','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/265.png?lm=1629382830','pais_club'=>'Greece','id_liga_club'=>'GR1','dificultad_club'=>'3'),
            58 => array('id_club'=>'683','slug_club'=>'olympiakos-piraus','nombre_club'=>'Olympiacos Piraeus','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/683.png?lm=1717764764','pais_club'=>'Greece','id_liga_club'=>'GR1','dificultad_club'=>'3'),

            // ITALIA
            59 => array('id_club'=>'1025','slug_club'=>'fc-bologna','nombre_club'=>'Bologna FC 1909','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/1025.png?lm=1626441324','pais_club'=>'Italy','id_liga_club'=>'IT1','dificultad_club'=>'3'),
            60 => array('id_club'=>'1047','slug_club'=>'como-1907','nombre_club'=>'Como 1907','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/1047.png?lm=1565704078','pais_club'=>'Italy','id_liga_club'=>'IT1','dificultad_club'=>'2'),
            61 => array('id_club'=>'12','slug_club'=>'as-rom','nombre_club'=>'AS Roma','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/12.png?lm=1751979202','pais_club'=>'Italy','id_liga_club'=>'IT1','dificultad_club'=>'1'),
            62 => array('id_club'=>'276','slug_club'=>'hellas-verona','nombre_club'=>'Hellas Verona','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/276.png?lm=1617228746','pais_club'=>'Italy','id_liga_club'=>'IT1','dificultad_club'=>'2'),
            63 => array('id_club'=>'398','slug_club'=>'lazio-rom','nombre_club'=>'SS Lazio','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/398.png?lm=1601537785','pais_club'=>'Italy','id_liga_club'=>'IT1','dificultad_club'=>'1'),
            64 => array('id_club'=>'410','slug_club'=>'udinese-calcio','nombre_club'=>'Udinese Calcio','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/410.png?lm=1688982584','pais_club'=>'Italy','id_liga_club'=>'IT1','dificultad_club'=>'3'),
            65 => array('id_club'=>'416','slug_club'=>'fc-turin','nombre_club'=>'Torino FC','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/416.png?lm=1438548174','pais_club'=>'Italy','id_liga_club'=>'IT1','dificultad_club'=>'2'),
            66 => array('id_club'=>'430','slug_club'=>'ac-florenz','nombre_club'=>'ACF Fiorentina','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/430.png?lm=1722844765','pais_club'=>'Italy','id_liga_club'=>'IT1','dificultad_club'=>'1'),
            67 => array('id_club'=>'46','slug_club'=>'inter-mailand','nombre_club'=>'Inter Milan','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/46.png?lm=1618900989','pais_club'=>'Italy','id_liga_club'=>'IT1','dificultad_club'=>'1'),
            68 => array('id_club'=>'5','slug_club'=>'ac-mailand','nombre_club'=>'AC Milan','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/5.png?lm=1605166627','pais_club'=>'Italy','id_liga_club'=>'IT1','dificultad_club'=>'1'),
            69 => array('id_club'=>'506','slug_club'=>'juventus-turin','nombre_club'=>'Juventus FC','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/506.png?lm=1626441487','pais_club'=>'Italy','id_liga_club'=>'IT1','dificultad_club'=>'1'),
            70 => array('id_club'=>'6195','slug_club'=>'ssc-neapel','nombre_club'=>'SSC Napoli','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/6195.png?lm=1753167643','pais_club'=>'Italy','id_liga_club'=>'IT1','dificultad_club'=>'1'),
            71 => array('id_club'=>'800','slug_club'=>'atalanta-bergamo','nombre_club'=>'Atalanta BC','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/800.png?lm=1438547428','pais_club'=>'Italy','id_liga_club'=>'IT1','dificultad_club'=>'1'),

            // ALEMANIA
            72 => array('id_club'=>'15','slug_club'=>'bayer-04-leverkusen','nombre_club'=>'Bayer 04 Leverkusen','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/15.png?lm=1710156317','pais_club'=>'Germany','id_liga_club'=>'L1','dificultad_club'=>'1'),
            73 => array('id_club'=>'16','slug_club'=>'borussia-dortmund','nombre_club'=>'Borussia Dortmund','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/16.png?lm=1396275280','pais_club'=>'Germany','id_liga_club'=>'L1','dificultad_club'=>'1'),
            74 => array('id_club'=>'18','slug_club'=>'borussia-monchengladbach','nombre_club'=>'Borussia Mönchengladbach','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/18.png?lm=1656585796','pais_club'=>'Germany','id_liga_club'=>'L1','dificultad_club'=>'3'),
            75 => array('id_club'=>'24','slug_club'=>'eintracht-frankfurt','nombre_club'=>'Eintracht Frankfurt','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/24.png?lm=1700074979','pais_club'=>'Germany','id_liga_club'=>'L1','dificultad_club'=>'1'),
            76 => array('id_club'=>'23826','slug_club'=>'rasenballsport-leipzig','nombre_club'=>'RB Leipzig','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/23826.png?lm=1619431624','pais_club'=>'Germany','id_liga_club'=>'L1','dificultad_club'=>'3'),
            77 => array('id_club'=>'27','slug_club'=>'fc-bayern-munchen','nombre_club'=>'Bayern Munich','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/27.png?lm=1729503608','pais_club'=>'Germany','id_liga_club'=>'L1','dificultad_club'=>'1'),
            78 => array('id_club'=>'60','slug_club'=>'sc-freiburg','nombre_club'=>'SC Freiburg','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/60.png?lm=1517249279','pais_club'=>'Germany','id_liga_club'=>'L1','dificultad_club'=>'3'),
            79 => array('id_club'=>'82','slug_club'=>'vfl-wolfsburg','nombre_club'=>'VfL Wolfsburg','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/82.png?lm=1503060755','pais_club'=>'Germany','id_liga_club'=>'L1','dificultad_club'=>'1'),

            // MÉXICO
            80 => array('id_club'=>'2407','slug_club'=>'cf-monterrey','nombre_club'=>'CF Monterrey','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/2407.png?lm=1406966074','pais_club'=>'Mexico','id_liga_club'=>'MEXA','dificultad_club'=>'3'),
            81 => array('id_club'=>'3631','slug_club'=>'cf-america','nombre_club'=>'CF América','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/3631.png?lm=1403472558','pais_club'=>'Mexico','id_liga_club'=>'MEXA','dificultad_club'=>'3'),
            82 => array('id_club'=>'3711','slug_club'=>'cd-cruz-azul','nombre_club'=>'CD Cruz Azul','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/3711.png?lm=1684395545','pais_club'=>'Mexico','id_liga_club'=>'MEXA','dificultad_club'=>'3'),
            83 => array('id_club'=>'4035','slug_club'=>'cf-pachuca','nombre_club'=>'CF Pachuca','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/4035.png?lm=1717797793','pais_club'=>'Mexico','id_liga_club'=>'MEXA','dificultad_club'=>'3'),
            84 => array('id_club'=>'7633','slug_club'=>'unam-pumas','nombre_club'=>'UNAM Pumas','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/7633.png?lm=1702405893','pais_club'=>'Mexico','id_liga_club'=>'MEXA','dificultad_club'=>'3'),

            // MLS
            85 => array('id_club'=>'1061','slug_club'=>'los-angeles-galaxy','nombre_club'=>'Los Angeles Galaxy','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/1061.png?lm=1493067070','pais_club'=>'United States','id_liga_club'=>'MLS1','dificultad_club'=>'3'),
            86 => array('id_club'=>'11141','slug_club'=>'toronto-fc','nombre_club'=>'Toronto FC','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/11141.png?lm=1410196948','pais_club'=>'Canada','id_liga_club'=>'MLS1','dificultad_club'=>'3'),
            87 => array('id_club'=>'40058','slug_club'=>'new-york-city-fc','nombre_club'=>'New York City FC','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/40058.png?lm=1726077065','pais_club'=>'United States','id_liga_club'=>'MLS1','dificultad_club'=>'3'),
            88 => array('id_club'=>'51828','slug_club'=>'los-angeles-fc','nombre_club'=>'Los Angeles FC','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/51828.png?lm=1511112738','pais_club'=>'United States','id_liga_club'=>'MLS1','dificultad_club'=>'3'),
            89 => array('id_club'=>'623','slug_club'=>'new-york-red-bulls','nombre_club'=>'New York Red Bulls','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/623.png?lm=1464530064','pais_club'=>'United States','id_liga_club'=>'MLS1','dificultad_club'=>'3'),
            90 => array('id_club'=>'69261','slug_club'=>'inter-miami-cf','nombre_club'=>'Inter Miami CF','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/69261.png?lm=1573561237','pais_club'=>'United States','id_liga_club'=>'MLS1','dificultad_club'=>'3'),

            // PAÍSES BAJOS
            91 => array('id_club'=>'234','slug_club'=>'feyenoord-rotterdam','nombre_club'=>'Feyenoord Rotterdam','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/234.png?lm=1721654567','pais_club'=>'Netherlands','id_liga_club'=>'NL1','dificultad_club'=>'2'),
            92 => array('id_club'=>'383','slug_club'=>'psv-eindhoven','nombre_club'=>'PSV Eindhoven','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/383.png?lm=1682925949','pais_club'=>'Netherlands','id_liga_club'=>'NL1','dificultad_club'=>'1'),
            93 => array('id_club'=>'610','slug_club'=>'ajax-amsterdam','nombre_club'=>'Ajax Amsterdam','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/610.png?lm=1750408025','pais_club'=>'Netherlands','id_liga_club'=>'NL1','dificultad_club'=>'1'),

            // PORTUGAL
            94 => array('id_club'=>'1075','slug_club'=>'sc-braga','nombre_club'=>'SC Braga','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/1075.png?lm=1432893871','pais_club'=>'Portugal','id_liga_club'=>'PO1','dificultad_club'=>'2'),
            95 => array('id_club'=>'294','slug_club'=>'benfica-lissabon','nombre_club'=>'SL Benfica','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/294.png?lm=1535908439','pais_club'=>'Portugal','id_liga_club'=>'PO1','dificultad_club'=>'1'),
            96 => array('id_club'=>'336','slug_club'=>'sporting-lissabon','nombre_club'=>'Sporting CP','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/336.png?lm=1621513752','pais_club'=>'Portugal','id_liga_club'=>'PO1','dificultad_club'=>'2'),
            97 => array('id_club'=>'720','slug_club'=>'fc-porto','nombre_club'=>'FC Porto','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/720.png?lm=1486310161','pais_club'=>'Portugal','id_liga_club'=>'PO1','dificultad_club'=>'1'),

            // ESCOCIA
            98 => array('id_club'=>'124','slug_club'=>'glasgow-rangers','nombre_club'=>'Rangers FC','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/124.png?lm=1657628093','pais_club'=>'Scotland','id_liga_club'=>'SC1','dificultad_club'=>'3'),
            99 => array('id_club'=>'371','slug_club'=>'celtic-glasgow','nombre_club'=>'Celtic FC','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/371.png?lm=1403615766','pais_club'=>'Scotland','id_liga_club'=>'SC1','dificultad_club'=>'3'),

            // TURQUÍA
            100 => array('id_club'=>'141','slug_club'=>'galatasaray-istanbul','nombre_club'=>'Galatasaray','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/141.png?lm=1406739071','pais_club'=>'Türkiye','id_liga_club'=>'TR1','dificultad_club'=>'2'),
            101 => array('id_club'=>'36','slug_club'=>'fenerbahce-istanbul','nombre_club'=>'Fenerbahce','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/36.png?lm=1753429185','pais_club'=>'Türkiye','id_liga_club'=>'TR1','dificultad_club'=>'2'),
            102 => array('id_club'=>'449','slug_club'=>'trabzonspor','nombre_club'=>'Trabzonspor','logo_url'=>'https://tmssl.akamaized.net//images/wappen/head/449.png?lm=1727269339','pais_club'=>'Türkiye','id_liga_club'=>'TR1','dificultad_club'=>'3'),

        ));
    }
}