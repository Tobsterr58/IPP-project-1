## Implementačná dokumentácia k 1. úlohe do IPP 2022/2023
**Meno a priezvisko:**  Tobiáš Štec \
**Login:** xstect00

### Implementácia

Riešenie prvej úlohy je implementované pomocou troch súborov:
- `parse.php`
- `generate.php`
- `regex.php`

kde `parse.php` slúži ako hlavný skript pre celý priebeh programu. Tento skript načíta súbor zo štandartného vstupu, ktorý následne rozdelí vstup na jednotlivé tokeny, odstráni komentáre a všetky zbytočné medzery resp. tabulátory. Skontroluje sa hlavička, počet argumentov a vygeneruje tradičnú hlavičku XML. V prípade nájdenia chyby sa vypíše prislušná chyba pomocou predom zadefinovaných pravidiel zo zadania. Ďalej sa pomocou príkazu `switch` rozhodne, ktorú sadu príkazov následne skript vykoná. 

Pomocou podmienok sa zistí či program pokračuje ďalej alebo či bola nájdená nejaká chyba. Ak všetko prebehlo v poriadku skript pokračuje a pomocou skriptu `generate.php` sa vygeneruje na štandartný výstup XML kód pre daný token. Súčasťou tohoto skriptu sú taktiež kontroly regulárnych výrazov pomocou skriptu `regex.php` kde sa skontroluje správnosť tokenov pomocou regulárnych výrazov pre jednotlivé prípady vstupu. V prípade, že sa vyskytne nejaká chyba tak tento skript vráti hodnotu `false` v prípade úspechu naopak `true`. 

Súčasťou skriptu `generate.php` je taktiež zmena jednotlivých tokenov, ktoré sú súčasťou reťazcov alebo premenných a pod. pomocou pravidiel výstupu tak, aby bol správny pre XML ako napríklad:
- `>` --> `&gt;`
- `<` --> `&lt;`
- `&` --> `&amp;`

Skript `generate.php` tiež v prípade nájdenia chyby vracia na štandartný chýbový výstup chybu č. 23. 