# Ga-php-laravel

Først må du sette opp en ny Google Analytics-tjeneste i Google API Console, og legge til Google Analytics-klientbiblioteket i Laravel-prosjektet ditt. Deretter kan du bruke følgende kode for å hente ut sessions og pageviews fra dimensjonen "default channel grouping" og lagre dem i en MySQL-database.

I koden over må du erstatte "YOUR_VIEW_ID" med ID-en til Google Analytics-visningen du vil hente data fra, og legge til riktig databaseoppsett for Laravel-prosjektet ditt. Du kan også tilpasse datoområdet, metrikkene og dimensjonene etter dine behov.
