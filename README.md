# Nastavení / informace

> Crew.sk VIP Callback.
  > Zdrojové kódy je zakázáno šířit/upravovat bez svolení autora!

##Použití:
1.) Základní nastavení - includes/config.php:

  > VYBERTE SI JEDNU VARIANTU!
 
    I.) Posílání příkazů přes webovou konzoli:
        a) $config['apiKey'] = 'KLÍČ, KTERÝ JSTE ZADALI PŘI VYTVOŘENÍ URL CALLBACKU';
        b) $config['webConsole'] = true;
        c) $config['serverID'] = 'ID SERVERU CREW.SK';
        d) $config['serverPass'] = 'HESLO PRO PŘÍSTUP K WEBOVÉ KONZOLI';
    
    II.) Posílání příkazů přes RCON:
        a) $config['apiKey'] = 'KLÍČ, KTERÝ JSTE ZADALI PŘI VYTVOŘENÍ URL CALLBACKU';
        b) $config['webConsole'] = false;
        c) $config['serverIP'] = 'IP SERVERU'; 
        d) $config['serverPort'] = 'PORT SERVER';
        e) $config['serverPass'] = 'RCON HESLO Z SERVER.CFG';
      
2.) Upravení příkazů a SMS kódů - index.php:

    switch($parameters['code']){
    case 'mojeVIP1': // PŘÍKLAD PRO MINECRAFT SERVER
      $commands[] = "pex group vip user add :nick";
      $commands[] = "say Hrac :nick si koupil startVIP. Dekujeme.";
      break;
    case 'MOJEVIP2': // PŘÍKLAD PRO CS 1.6
      $commands[] = "nejaky prikaz pro CS 1.6 :steamid";
      $commands[] = "say Hrac :steamid si koupil silverVIP. Dekujeme.";
      break;
    default:
      exit(core::status_msg('error','unknown_code'));
    }

