# 03 — Website Analyse & Verbeteraanbevelingen: Jim Ruimt Op

> **Onderzoeksdatum:** 11 april 2026  
> **Doel:** Pagina-voor-pagina analyse van de huidige website met concrete, geprioriteerde verbeterpunten voor conversie, vertrouwen en SEO.  
> **Website:** 4 pagina's — index.html, diensten.html, over-mij.html, contact.html

---

## 1. Algemeen Oordeel

De website heeft een **sterk visueel fundament**: modern design, goede kleurkeuze (navy = vertrouwen, cream = warmte), prettige typografie en een empathische tone-of-voice. Dit is een solide basis.

**Het grote probleem:** De website is momenteel een mooie brochure die **niet converteert** en **niet gevonden wordt**. De volgende kritieke elementen ontbreken:

- Echte contactgegevens (alles zijn placeholders)
- Werkende contactformulieren
- Telefoonnummer in de header
- WhatsApp-knop
- Google Maps
- Reviews / sociaal bewijs
- Schema markup voor Google
- Meta descriptions voor zoekmachines

---

## 2. Kritieke Issues — Topprioriteit

Dit zijn de issues die **direct omzet kosten** en als eerste opgelost moeten worden.

### 🔴 KRITIEK #1 — Contactformulieren werken niet
**Pagina's:** index.html, contact.html  
**Probleem:** Beide formulieren hebben `action="#"` — dit betekent dat een ingevuld formulier nergens naartoe gaat. Leads gaan verloren.  
**Oplossing:** Koppel formulieren aan:
- **Formspree** (gratis, eenvoudig): vervang `action="#"` door `action="https://formspree.io/f/[jouw-id]"`
- Of **Netlify Forms** als de site op Netlify staat: voeg `netlify` attribuut toe aan `<form>`
- Of een simpele PHP mailto-backend

---

### 🔴 KRITIEK #2 — Nep contactgegevens
**Pagina's:** Alle pagina's  
**Probleem:** `06 1234 5678`, `info@jimruimtop.nl`, `Spoorlaan 350 5038 CC` zijn placeholders. Als een klant belt of mailt, lukt het niet. Ondermijnt direct het vertrouwen.  
**Oplossing:** Vervangen door echte gegevens zodra deze bekend zijn.

---

### 🔴 KRITIEK #3 — Geen telefoonnummer in header
**Probleem:** Voor een lokale dienstverlener (zeker gericht op senioren en nabestaanden) is het telefoonnummer de primaire contactmethode. Het ontbreekt volledig in de navigatiebalk.  
**Wat concurrenten doen:** JHC heeft het telefoonnummer groot en klikbaar bovenaan.  
**Oplossing:** Voeg toe aan de header, naast of boven de navigatie:
```
📞 06 XX XX XX XX
```
Op mobiel moet dit een `<a href="tel:06XXXXXXXX">` zijn zodat men direct kan bellen.

---

### 🔴 KRITIEK #4 — Geen WhatsApp-knop
**Probleem:** De doelgroep (senioren, nabestaanden, drukke families) communiceert primair via WhatsApp. Een floating WhatsApp-knop rechtsonder in beeld is tegenwoordig standaard voor lokale dienstverleners.  
**Oplossing:** Voeg een floating button toe:
```html
<a href="https://wa.me/31612345678?text=Hallo%20Jim,%20ik%20heb%20een%20vraag%20over%20woningontruiming"
   class="fixed bottom-6 right-6 bg-green-500 text-white p-4 rounded-full shadow-xl z-50">
  WhatsApp
</a>
```

---

### 🔴 KRITIEK #5 — Geen Google Maps embed
**Probleem:** Alle sterke concurrenten (JHC, Adelaar, De Woningontruimers) hebben een Google Maps embed op hun contactpagina. Dit:
- Vergroot het vertrouwen ("dit is een echt, verifieerbaar bedrijf")
- Versterkt de lokale SEO-signalen
- Helpt klanten het werkgebied te visualiseren  

**Oplossing:** Vervang de map-placeholder in `contact.html` en `over-mij.html` door een echte Google Maps iframe embed.

---

## 3. Pagina-voor-Pagina Analyse

---

### 📄 index.html — Homepage

#### Sterke punten
- ✅ Krachtige hero-sectie met duidelijke propositie
- ✅ Overlappende kaarten (Basic/Comfort/Premium) zijn visueel aantrekkelijk
- ✅ Diensten overzicht is duidelijk en scanbaar
- ✅ Video review sectie (concept) is goed idee
- ✅ Contact formulier direct op homepage beschikbaar

#### Verbeterpunten

| # | Probleem | Impact | Actie |
|---|----------|--------|-------|
| 1 | Telefoonnummer ontbreekt in header | Hoog | Toevoegen naast "Gratis Intake" knop |
| 2 | Hero-sectie heeft geen lokale SEO-tekst | Hoog | Voeg ergens "Woningontruiming Tilburg" als H2 toe |
| 3 | Geen "Hoe werkt het" sectie | Medium | Voeg 3-stappen proces toe (intake → offerte → uitvoering) |
| 4 | Geen trust badges | Hoog | KvK, verzekerd, milieubewust, bezemschoon garantie |
| 5 | Formulier werkt niet | Kritiek | Koppelen aan Formspree/Netlify |
| 6 | "Review van de West" — geen echte review | Medium | Vervangen door echte citaat + naam of wachten op echte klant |
| 7 | Geen WhatsApp floating button | Hoog | Toevoegen (zie boven) |
| 8 | Copyright © 2024 | Laag | Bijwerken naar 2025 of dynamisch jaar |
| 9 | Geen LocalBusiness schema markup | Hoog | Toevoegen in `<head>` (zie bestand 02) |
| 10 | Geen meta description | Hoog | Toevoegen in `<head>` |
| 11 | "Inboedel opkopen" ontbreekt | Medium | Voeg toe als extra USP in diensten overzicht |
| 12 | Geen Google Maps | Medium | Toevoegen in of na contact formulier sectie |

#### Aanbevolen nieuwe sectie: "Hoe werkt het?"

```
Stap 1: Gratis Intake
→ Jim komt langs voor een vrijblijvende inspectie.

Stap 2: Duidelijke Offerte
→ Binnen 48 uur ontvangt u een vaste prijs. Geen verrassingen.

Stap 3: Wij Regelen Alles
→ Van inboedel tot afval — bezemschoon opgeleverd.
```

#### Aanbevolen trust-sectie (trustbalk)

Voeg een horizontale balk toe met:
- 🏛️ KvK geregistreerd
- 🛡️ Verzekerd
- ♻️ Milieubewuste afvoer
- ⭐ Bezemschoon gegarandeerd
- 📞 Binnen 48 uur teruggebeld

---

### 📄 diensten.html — Dienstenpagina

#### Sterke punten
- ✅ 6 diensten goed beschreven met bullet points
- ✅ Pakketten (Basic/Comfort/Premium) met vaste prijzen
- ✅ CTA aan het einde

#### Verbeterpunten

| # | Probleem | Impact | Actie |
|---|----------|--------|-------|
| 1 | Prijstabel te simpel | Hoog | Voeg tabel toe per woningtype (zie hieronder) |
| 2 | "Inboedel opkopen" ontbreekt | Hoog | Eigen sectie: "Bespaar op uw ontruiming" |
| 3 | Spoedontruiming ontbreekt | Hoog | Toevoegen als 7e dienst |
| 4 | Geen FAQ schema markup | Medium | Toevoegen voor rich snippets in Google |
| 5 | Geen meta description | Hoog | Toevoegen |
| 6 | Geen zoekwoord in H1 of H2 | Hoog | "Woningontruiming Tilburg" in een H2 |
| 7 | Bedrijfsontruiming ontbreekt | Laag | Toevoegen (toekomstige groei) |
| 8 | Geen "werkgebied" vermelding | Medium | Voeg toe: actief in Tilburg, Breda, Den Bosch, etc. |

#### Aanbevolen prijstabel per woningtype

| Type woning | Geschatte prijs | Inbegrepen |
|-------------|----------------|-----------|
| Garage / Zolder (tot 20m²) | Vanaf €295 | Ontruiming, afvoer, bezemschoon |
| Seniorenkamer (ca. 35m²) | Vanaf €395 | Ontruiming, sortering, bezemschoon |
| Appartement (2–3 kamers) | Vanaf €595 | Complete ontruiming, afvoer |
| Eengezinswoning | Vanaf €695 | Volledige woning, bezemschoon |
| Grote woning / villa | Op aanvraag | Maatwerk, meerdere dagen |

> **Tip:** Vermeld altijd: "Prijzen zijn inclusief transport en arbeid. Restafvalverwerking kan extra kosten met zich meebrengen. Bruikbare inboedel wordt verrekend."

#### Aanbevolen nieuwe sectie: "Inboedel Opkopen"

```
💡 Bespaar op uw ontruiming

Heeft de woning nog bruikbare meubels, apparaten of andere items?
Jim beoordeelt de inboedel en biedt een eerlijke vergoeding aan.
Dit bedrag wordt direct van de ontruimingskosten afgetrokken.

→ Minder kosten voor u, minder afval voor het milieu.
```

---

### 📄 over-mij.html — Over Jim

#### Sterke punten
- ✅ Persoonlijk verhaal over grootouders — emotioneel sterk
- ✅ Drie kernwaarden (empathie, discretie, structuur) goed verwoord
- ✅ Werkgebied sectie aanwezig
- ✅ Mooie bento-grid layout

#### Verbeterpunten

| # | Probleem | Impact | Actie |
|---|----------|--------|-------|
| 1 | Geen KvK-nummer vermeld | Hoog | Toevoegen voor zakelijk vertrouwen |
| 2 | Geen "verzekerd" vermeld | Hoog | Toevoegen zodra verzekering geregeld |
| 3 | Werkgebied-sectie mist wijken Tilburg | Medium | Voeg alle wijken toe (Centrum, Noord, Oost, Zuid, West, Reeshof) |
| 4 | Geen achtergrond/opleiding Jim | Medium | Wat is Jim's achtergrond? Eerdere ervaring? |
| 5 | Map placeholder heeft geen echte kaart | Medium | Google Maps embed toevoegen |
| 6 | Geen meta description | Hoog | Toevoegen |
| 7 | Geen photo van echt werk (voor/na) | Medium | Bij eerste klus maken en toevoegen |

#### Aanbevolen toevoeging: Feitenbalk over Jim

```
✔ Gevestigd in Tilburg-Noord
✔ KvK: [nummer invullen]
✔ Verzekerd voor aansprakelijkheid
✔ Actief in regio Tilburg en omstreken
✔ Gratis, vrijblijvende intake
```

---

### 📄 contact.html — Contactpagina

#### Sterke punten
- ✅ Goed gestructureerde pagina (formulier + contactgegevens naast elkaar)
- ✅ FAQ sectie aanwezig (goede content)
- ✅ Openingstijden duidelijk vermeld
- ✅ "Spoed? Bel direct!" emergency sectie

#### Verbeterpunten

| # | Probleem | Impact | Actie |
|---|----------|--------|-------|
| 1 | Formulier werkt niet | Kritiek | Koppelen aan Formspree / Netlify Forms |
| 2 | Geen WhatsApp-link | Hoog | Toevoegen naast telefoon en email |
| 3 | Google Maps placeholder | Hoog | Echte embed toevoegen |
| 4 | Nep telefoonnummer | Kritiek | Vervangen door echt nummer |
| 5 | Bel-link niet klikbaar op mobiel | Hoog | `href="tel:06XXXXXXXX"` toevoegen |
| 6 | FAQ mist schema markup | Medium | JSON-LD FAQ schema toevoegen |
| 7 | Geen meta description | Hoog | Toevoegen |
| 8 | Geen "reactietijd garantie" | Medium | "Wij reageren binnen 48 uur" toevoegen |
| 9 | Adres in footer wijkt af van contact | Laag | NAP-consistentie bewaken |

#### Aanbevolen nieuwe contactmogelijkheden

```html
<!-- Naast het formulier toevoegen: -->
<div class="contact-opties">
  <a href="tel:06XXXXXXXX">📞 Bel direct: 06 XX XX XX XX</a>
  <a href="https://wa.me/31612345678">💬 WhatsApp: direct chatten</a>
  <a href="mailto:info@jimruimtop.nl">✉️ Email: info@jimruimtop.nl</a>
</div>
```

---

## 4. Ontbrekende Pagina's (Aanbevolen toe te voegen)

### Pagina: Werkgebied / Locaties
- URL: `werkgebied.html` of als sectie op over-mij
- Inhoud: Per stad/wijk een alinea (Tilburg Centrum, Tilburg-Noord, Tilburg-Oost, etc.)
- SEO-waarde: Scoort op "[stad] woningontruiming"-zoekopdrachten

### Pagina: Blog / Tips
- URL: `blog.html`
- Eerste artikel: "Wat kost een woningontruiming in Tilburg in 2025?"
- Zie bestand `02-seo-en-zoekwoorden.md` voor de volledige contentstrategie

### Pagina: Spoedontruiming
- URL: `spoedontruiming.html`
- Inhoud: Wanneer is spoed nodig, hoe snel Jim komt, extra kosten
- Doelgroep: Verhuurders, woningcorporaties, nabestaanden met deadline

---

## 5. Conversie-optimalisatie — Algemene Tips

### Sticky Header met telefoonnummer
De header is sticky (blijft in beeld bij scrollen) — goed! Voeg hier het telefoonnummer aan toe. Op mobiel groot en klikbaar.

### Social Proof — Testimonials
Zonder reviews is de site een lege belofte. Zodra de eerste klant tevreden is:
1. Vraag om een korte quote ("Wat vond u het fijnste aan de samenwerking met Jim?")
2. Vraag toestemming voor naam + eventueel foto
3. Plaats op homepage en dienstenpagina

**Tijdelijke oplossing:** Gebruik een neef, buur of vriend die een proefklus heeft gedaan voor een eerste testimonial.

### CTA-knoppen Analyse

| Knop | Pagina | Oordeel | Aanbeveling |
|------|--------|---------|-------------|
| "Kennismakingsgesprek Inplannen" | Home hero | ✅ Goed | Voeg telefoonnummer toe als alternatief |
| "Gratis Intake" (header) | Alle | ✅ Goed | Behouden |
| "Bekijk alle diensten" | Home | ✅ Goed | Behouden |
| "Maak een afspraak" (Premium card) | Home | ✅ Goed | Behouden |
| "Verstuur" (formulier) | Home | ⚠️ Werkt niet | Formulier functioneel maken |
| "Aanvragen" (diensten) | Diensten | ✅ Goed | Voeg telefoonnummer toe als alternatief |
| "Gratis Intake Aanvragen" (CTA) | Diensten | ✅ Goed | Behouden |

### Urgentie & Schaarste
Ontruimingsbedrijven kunnen spelen met urgentie:
- "Beschikbaar voor spoedklussen"
- "Momenteel beschikbaar in regio Tilburg"
- "Vraag vandaag een gratis intake aan — doorgaans binnen 48 uur"

---

## 6. Technische Verbeterpunten

### Afbeeldingsnamen (SEO)
Alle afbeeldingen hebben UUID-namen (`file_24---f1a3f6be...jpg`). Dit is slecht voor SEO.

| Huidig | Aanbevolen naam |
|--------|----------------|
| `file_24---f1a3f6be-ff29-4eb4-9169-64c58267bf1c.jpg` | `jim-ontruimt-woning-tilburg.jpg` |
| `file_25---53b04ee2-5183-4b2a-88a1-877f480030a6.jpg` | `jim-ruimt-op-logo.jpg` |
| `file_26---05787c6d-5a2f-4a29-a396-a37570acc71c.jpg` | `jim-ruimt-op-review-video.jpg` |

### Alt-teksten
Alle `alt`-attributen zijn wel aanwezig maar kunnen beter:

| Huidig alt | Beter |
|-----------|-------|
| `"Jim - Uw specialist in ontruiming"` | `"Jim, woningontruiming specialist Tilburg"` |
| `"Video review placeholder"` | `"Klantreview video - Jim Ruimt Op Tilburg"` |

### Open Graph Tags (ontbreken volledig)
Voor delen op social media en betere weergave in Google:
```html
<meta property="og:title" content="Jim Ruimt Op — Woningontruiming Tilburg"/>
<meta property="og:description" content="Persoonlijk ontruimingsbedrijf in Tilburg. Empathisch, discreet, bezemschoon."/>
<meta property="og:image" content="https://www.jimruimtop.nl/jim-ruimt-op-logo.jpg"/>
<meta property="og:url" content="https://www.jimruimtop.nl"/>
<meta property="og:type" content="website"/>
```

---

## 7. Visuele & UX Aanbevelingen

### Wat goed werkt (behouden)
- De kaartjes-lay-out (Basic/Comfort/Premium) is origineel en trekt de aandacht
- De kleurenpalet (navy + cream + cyan + green) is warm en professioneel
- De scriptfont ("Zorgeloos geregeld!") geeft persoonlijkheid
- De "Mijn Belofte aan U" sectie op over-mij is sterk

### Verbeterpunten UX

| Item | Probleem | Aanbeveling |
|------|----------|-------------|
| Foto's | Dezelfde 2–3 foto's op alle pagina's | Echte foto's van Jim bij klussen maken |
| Video | Placeholder met play-knop maar geen video | Echte video klantreview toevoegen (of verwijderen) |
| Kaart | Placeholder icoon als kaart | Google Maps embed |
| Sociale media | Geen sociale media links | Facebook/Instagram toevoegen (minimaal Facebook) |
| WhatsApp | Ontbreekt | Floating knop toevoegen |
| Telefoonnummer | Niet klikbaar, alleen in footer | In header + klikbaar maken |

---

## 8. Prioriteitenmatrix

| Prioriteit | Item | Effort | Impact |
|------------|------|--------|--------|
| 🔴 Nu doen | Echte contactgegevens invullen | Laag | Hoog |
| 🔴 Nu doen | Formulieren functioneel maken | Laag | Hoog |
| 🔴 Nu doen | Telefoonnummer in header | Laag | Hoog |
| 🔴 Nu doen | Google Mijn Bedrijf aanmaken | Laag | Hoog |
| 🟠 Snel doen | WhatsApp floating button | Laag | Hoog |
| 🟠 Snel doen | Meta descriptions alle pagina's | Laag | Hoog |
| 🟠 Snel doen | LocalBusiness schema markup | Medium | Hoog |
| 🟠 Snel doen | Google Maps embed | Laag | Medium |
| 🟡 Plannen | Trust badges sectie | Medium | Hoog |
| 🟡 Plannen | "Hoe werkt het" sectie | Medium | Medium |
| 🟡 Plannen | Inboedel opkopen sectie | Medium | Medium |
| 🟡 Plannen | Prijstabel per woningtype | Medium | Hoog |
| 🟢 Later | Blog / eerste artikel | Hoog | Hoog (lange termijn) |
| 🟢 Later | Echte foto's klussen | Medium | Hoog |
| 🟢 Later | Reviews verzamelen | Laag | Hoog (duurt tijd) |
| 🟢 Later | Locatie-specifieke pagina's | Hoog | Hoog (lange termijn) |

---

## 9. Wat de Concurrenten Hebben Dat Jim Nog Niet Heeft

| Feature | JHC | Adelaar | Jim | Actie |
|---------|-----|---------|-----|-------|
| Persoonlijk gezicht (naam + foto) | ✅ Joey | ❌ | ✅ Jim | Goed! Uitbouwen |
| Telefoonnummer in header | ✅ | ✅ | ❌ | Toevoegen |
| WhatsApp knop | ✅ | ✅ | ❌ | Toevoegen |
| Google Maps embed | ✅ | ✅ | ❌ | Toevoegen |
| Werkende contactformulieren | ✅ | ✅ | ❌ | Repareren |
| Prijstabel per woningtype | ✅ | ✅ | ⚠️ Beperkt | Uitbreiden |
| Inboedel opkopen vermeld | ✅ | ✅ | ❌ | Toevoegen |
| Spoedontruiming dienst | ✅ | ✅ | ❌ | Toevoegen |
| Blog/content | ✅ | ✅ | ❌ | Prioriteit plannen |
| Google Mijn Bedrijf | ✅ | ✅ | ❌ | Nu aanmaken |
| Reviews | ✅ | ✅ | ❌ | Verzamelen na eerste klus |
| Trust badges / keurmerken | ✅ | ⚠️ | ❌ | Toevoegen |
| Werkgebied per wijk | ✅ | ✅ | ⚠️ Beperkt | Uitbreiden |
| Schema markup | ✅ | ✅ | ❌ | Toevoegen |
| Empathische tone-of-voice | ⚠️ Matig | ❌ | ✅ Sterk | **Jim's onderscheid! Uitbouwen** |
| Seniorenspecialist focus | ❌ | ❌ | ✅ | **Jim's onderscheid! Uitbouwen** |

---

## 10. Slotadvies

De website van Jim Ruimt Op heeft een uitstekend fundament. De **empathische positionering en persoonlijke aanpak zijn uniek** in de Tilburgse markt en moeten koste wat het kost behouden worden.

**De drie meest urgente acties voor morgen:**
1. **Google Mijn Bedrijf aanmaken** — Kosteloos, direct zichtbaar in Google Maps
2. **Echte contactgegevens invullen** — Niets schaadt meer dan een nep telefoonnummer
3. **Formulieren werkend maken** — Leads mogen niet verloren gaan

**De drie acties met de grootste ROI op middellange termijn:**
1. **Eerste blog artikel** — "Wat kost een woningontruiming Tilburg" scoort snel op Google
2. **Reviews verzamelen** — 5 Google-reviews is het minimum voor vertrouwen
3. **Partnernetwerk opbouwen** — 1 uitvaartondernemer als partner = structurele instroom

---

*Dit document maakt deel uit van de Jim Ruimt Op research serie. Zie ook:*  
*→ `01-markt-en-concurrentie.md`*  
*→ `02-seo-en-zoekwoorden.md`*
