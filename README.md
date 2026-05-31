# Zpovědnice



Závěrečný projekt 2026 | webové aplikace | Tobias Gerlich, 3.A | SPŠE Havířov


[klikněte zde](https://www.zpovednice.great-site.net)
---

## Obsah

- [Přehled](#přehled)
- [Funkce](#funkce)
- [Struktura projektu](#struktura-projektu)
- [Databáze](#databáze)
- [Technologie](#technologie)
- [Spuštění lokálně](#spuštění-lokálně)
- [Bezpečnostní poznámky](#bezpečnostní-poznámky)

---

## Přehled

Jednoduchá anonymní web. aplikace pro sdílení zpovědí a 
otázek, isnpirovaná stránkami [zpovědnice.cz](https://www.zpovednice.cz) 
a [alik.cz](https://www.alik.cz/p/zdravotni). 
Cílem byly
- jednoduchost
- anonymita
- interaktivita (hlasování, komentáře).
- čistý, přehledný a použitelný moderní design

[Obsah](#obsah)


---

## Funkce

- **Anonymní příspěvky** — každý může napsat zpověď bez registrace
- **Komentáře** — na příspěvky jde odpovídat
- **Hlasování** — reddit-like systém upvote/downvote
- **Ochrana proti duplicitnímu hlasování** — hlasy jsou vázané na IP adresu(vote.php a tabulka votes je **AI generated**, sám bych to nedokázal)
- **Řazení feedu** — nejnovější, nejstarší, nejoblíbenější, nejméně oblíbené
- **Zkrácený náhled** — příspěvky delší než 500 znaků jsou ve feedu zkráceny, celé se dají zobrazit po rozkliknutí příspěvku
- **Responzivní design** — přizpůsobeno pro desktop, tablet i mobil (s mobilním zobrazením jsem využil pomoci AI).

---

## Struktura projektu

```
htdocs/
├── index.php               # Úvodní stránka
├── feed.php                # Seznam všech příspěvků s řazením
├── post.php                # Detail příspěvku + komentáře
├── add_post.php            # Formulář pro přidání příspěvku
├── add_comment.php         # Zpracování přidání komentáře
├── vote.php                # Zpracování hlasování
├── css/
│   └── style.css           # Stylizace s mobilním zobrazením
└── includes/
    ├── db.php              # Připojení k databázi
    ├── header.php          # Hlavička stránky (HTML head + nav)
    └── footer.php          # Patička stránky
```

---

## Databáze

MariaDB 10.11.3, MySQL 8.0.33, InnoDB, UTF-8mb4, 3 tabulky (posts, comments, votes)
Projekt používá MySQL databázi hostovanou na InfinityFree DB serverech.

### Tabulky

**posts**

| Sloupec      | Typ          | Popis                        |
|--------------|--------------|------------------------------|
| `id`         | INT, PK, AI  | Primární klíč                |
| `title`      | VARCHAR      | Nadpis příspěvku             |
| `content`    | TEXT         | Obsah zpovědi                |
| `votes`      | INT          | Celkový počet hlasů          |
| `created_at` | TIMESTAMP    | Čas vytvoření                |

**comments**

| Sloupec      | Typ              | Popis                        |
|--------------|------------------|------------------------------|
| `id`         | INT, PK, AUT_INC | Primární klíč                |
| `post_id`    | INT, FK          | Odkaz na příspěvek           |
| `content`    | TEXT             | Obsah komentáře              |
| `created_at` | TIMESTAMP        | Čas vytvoření                |

**votes** (AI generated)

| Sloupec      | Typ              | Popis                              |
|--------------|------------------|------------------------------------|
| `id`         | INT, PK, AUT_INC | Primární klíč                      |
| `post_id`    | INT, FK          | Odkaz na příspěvek                 |
| `ip`         | VARCHAR          | IP adresa hlasujícího              |
| `value`      | TINYINT          | Hodnota hlasu (`1` nebo `-1`)      |

---

## Technologie

| Technologie | Využití                                 |
|-------------|-----------------------------------------|
| PHP         | Backend,                                |
| MySQL       | Databáze                                |
| HTML5/CSS3  | Frontend, responzivní design, struktura |
| MariaDB SQL | Připojení k databázi                    |

---

## Spuštění lokálně

### Požadavky

- PHP 8.0+
- MySQL / MariaDB
- Webový server (Apache)

