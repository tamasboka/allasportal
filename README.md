# :briefcase: Állásportál - **Vizsgaremek**

## :pushpin: Tartalomjegyzék

- [:man_technologist: Fejlesztők](#man_technologist-fejlesztők)
- [:information_source: A projektről](#information_source-a-projektről)
- [:closed_book: Felhasználói dokumentáció](#closed_book-felhasználói-dokumentáció)
- [:computer: Fejlesztői dokumentáció](#computer-fejlesztői-dokumentáció)

## :man_technologist: Fejlesztők
- [**Bóka Tamás**](https://github.com/tamasboka)
    - Backend
- [**Beretzky Bence**](https://github.com/BBence1)
    - Frontend

## :wrench: Setup
### Backend
1) ```cd backend```
2) Windows: ``copy .env.example .env`` | Linux: ```cp .env.example .env``` VAGY manuálisan át kell nevezni a .env.example-t .env-re
3) ```composer i```
4) ```php artisan key:generate```
5) ```php artisan migrate```
6) ```php artisan db:seed```
7) ```php artisan serve```

### Frontend
1) ```cd frontend```
2) ```npm i``` VAGY ```npm install```
3) ```npm run dev```
## :information_source: A projektről

> A projektünk célja egy olyan hibrid állásportál elkészítése, ami egyszerre ad lehetőséget szabadúszóknak, akik egyszeri munkát keresnek és cégeknek is, akik full-time állásokhoz keresnek alkalmazottakat.
- Mire nyújt megoldást?
    1) Hatékonyság
        - Célunk a munkaerőpiaci kereslet és kínálat gyorsabb összekapcsolása.
    2) Rugalmasság
        - Megkönnyítjük a bevételszerzést a munkavállalóknak, a munkaadóknak pedig egyszerű és átlátható folyamatot biztosítunk a legalkalmasabb jelöltek megtalálására.
- Kiknek szól?
    > Úgy terveztük, hogy bárki számára tudjon segítséget nyújtani a szolgáltatásunk, nem számít, hogy mi célből. Legyen szó akár tartalomgyártóról, aki indexképeket csináltatna vagy videót szerkesztene, legyen szó tanárról, aki szívesen tartana órákat egy iskolában, legyen szó magántanárról, marketingesről, grafikusról, a lehetőségek száma szinte *végtelen*. 
    #### Íme pár példa:
    1) Szabadúszóknak
        - Programozó
        - Fényképész
    2) Hagyományos munkakeresőknek
        - Programozó
        - Tanár
        - Könyvelő
    3) Cégeknek / Intézményeknek
        - Bankok
        - Iskolák
        - Boltok
    #### *...és ez még csak a jéghegy csúcsa!*
- Kezdés dátuma: ```2026. 01. 22```
- Befejezés dátuma: ```2026 04 17``` előtt

## :closed_book: Felhasználói dokumentáció

- 

## :computer: Fejlesztői dokumentáció

- Alkalmazott technológiák
    - Frontend: [Vue.js](https://vuejs.org)
    - Backend: [Laravel](https://laravel.com)
    - Adatbázis: MySQL