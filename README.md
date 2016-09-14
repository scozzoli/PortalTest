# Portal 1
## Sorry :(
I'm sorry ... but till now the documentation is only in italian.

## Obbiettivo
### Piccola storia (*che potete tranquillamente saltare*)

Durante la mia vita lavorativa, mi sono trovato a lavorare come CED interno in alcune aziende, ed il mio lavoro principale era mantenere il gestionale ed eseguire interrogazioni personalizzate.
Spesso mi veniva anche chiesto di implementare strumenti per integrare le funzionalità dell'*ERP* o del *CRM*.  

La maggior parte dei parchi macchine erano estremamente eterogenei (window dal 3.1 in poi e linux in tutte le più esotiche declinazioni), per cui ho optato per la creazione di interfacce web. 
All'inizio pensavo di usare dei framework già belli che pronti ... ma o facevano troppo, o non facevano quello che mi serviva... per cui ho optato per crearmene uno su misura!

Tutto questo è partito nel *lontano* 2000 (lontano perché era ancora considerato un browser **IE6** `<RandomBestemmia>`) ed ovviamente col tempo le esigenze dei vai datori di lavoro sono aumentate, e con loro il mio piccolo framework.

Visto che nel panorama attuale esiste nulla che dia questo tipo di elasticità nello sviluppo, ho pensato di ripulirlo e di metterlo a disposizione di chi lo volesse.

### Che cos'è quindi?
Portal1 è un framework facile da usare che punta ad uno sviluppo rapido di applicazioni web... che effettivamente vuol dire tutto e niente... Diciamo che 

* **è :**
	* *Modulare* - Ossia ogni strumento è indipendente dagli altri, a meno che non si crei un modulo common ... ma questa è un'altra storia
	* *Multilingua* - Supporto nativo delle traduzioni utilizzando il tag **non** html5 `<i18n>`
	* *Stilizzabile* - I temi sono personalizzabili in nelle maniere più svariate (di base ho messo solo quello _material_)
	* *DB free* - Non necessita di un DB per funzionare
	* *Multi DB* - Si possono configurare un numero indefinito di connessioni a svariati DB
	* *Personalizzabile* - Menù, permessi, stili, DB ... sono tutti configurabili per utente
	* *Semplice* - Quindi anche facile da modificare anche nelle sue meccaniche di base
* **non è :**
	* *One page application* - Quindi meno problemi nella gestione delle sessioni
	* *Marmoreo* - Come una panda 4x4 ... non va forte, ma ci puoi fare tutto e va ovunque... anche senza olio
	* *Pesante* - Lo sviluppo su di un raspberry vecchio modello :D

## Prerequisiti

Per poter installare portal 1 serve (in grassetto i requisiti indispensabili):

* **Apache2** (con SSL)
* **PHP5**
	* **Libreria GD** (per le icone) 
	* Sysbase (per collegarsi a SqlServer)
	* Librerie OCI (Per collegarsi ad Oracle)
	* Librerie Mysql (Per collegarsi a mysql)
	* Librerie Postgress (indovina un po' perchè)

una volta preparato il webserver, basta copiare l'intero progetto dentro `www` ed il contenuto della cartella `documents/default_Settings` dentro `settings` ed il gioco è fatto!

Le configurazioni iniziali sono in formato json e quindi possono essere editate tranquillamente (poi consiglio di metterle in formato cifrato)

La password di default di root è `pi`

## Cosa fa di base?

Di base Portal1 è fornito di:
* Modulo per la configurazione di utenti, gruppi, db, menù e moduli
* Modulo per la gestione delle traduzioni
* Modulo per i test
* Modulo per la gestione delle query parametriche con grafici, esportazione in excel, ecc... (tutto sotto permessi)
* Modulo per la ricerca di colonne e tabelle dei vai db configurati (e per la gestione delle sessioni) di:
	* Oracle
	* SqlServer

Se uno si intende di SQL e poco di programmazione il modulo della gestione delle query potrebbe tornargli **molto** utile.

## Documentazione

La documentazione completa è nella cartella 
[documents](https://github.com/scozzoli/portal1/tree/master/documents)