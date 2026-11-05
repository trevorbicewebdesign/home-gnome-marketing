# Home Gnome marketing site: design brief

Worked out on 2026-11-05 with the owner's ChatGPT thread
(https://chatgpt.com/c/6ac44bfe-c498-83e8-b667-3a41190eb000, which also holds the October app
design work and the full-size comps). This file is the record the site is built from; the
thread is the source of the images.

## The product, for the copy

Home Gnome is a self-hosted server that keeps track of what a household has and where it is: a
catalog of the things you keep (known items), how many are in the house and in which place
(entries), the places themselves (rooms, shelves, boxes, each with a sticker or NFC code), what
was bought where and for how much, who owns what, and the household's to-dos. One Docker image
on a home server or NAS.

| | |
| --- | --- |
| Free | **the whole product, self-hosted**: server, admin, web app (the phone view of the house), Home Assistant integration (stock sensors, actions, NFC blueprints), Alexa skill; no licence key |
| Paid | a **Hosted** edition (private instance per household, subscription, price not announced) |
| Planned | a native iOS/Android app for barcode and NFC scanning: one-time purchase for self-hosters, inclusion with Hosted proposed |
| Licence | proprietary, not open source |

This is the model decided on 2026-11-05 (round 3, [plans-and-model.md](plans-and-model.md)).
Round 1 below was briefed with the earlier "free admin, paid web app" split; where the two
disagree, round 3 wins.

Audience: self-hosters and home-lab people, Home Assistant users, and organised households who
want to know what is in the pantry, garage and closets without a spreadsheet.

Editorial rules the copy must keep (the product's nuances):

- The catalog says what something *is*; entries record the actual stock or individual belongings.
- One opened jar and one sealed jar share a known item and are separate entries.
- A tote is a thing that holds other things: show it once, with its contents beneath it.
- Current place and usual place differ: "In the garage · Usually on the workshop shelf."
- Stickers (QR) and NFC tags open the thing or place. The native scanning app is *planned*;
  never imply it exists.
- AI intake and Ask belong in the paid web-app tour, with their requirements stated. The house
  does not inventory itself.
- Say what is free, what is paid, what is planned, and that self-hosted is not open source.
  No blanket "everything stays offline" claims (Alexa and AI features call out).
- Until the free download is public, the primary CTA is **Get early access**; then
  **Download free**. No invented price: pricing shows a status, never $0.

## Positioning

Eyebrow: **Household inventory, self-hosted**

Tagline (recommended): **Know what you have. Find where it is.**

Subhead (recommended): Home Gnome keeps track of your household's things, places, purchases and
to-dos. Run it on your own server, with a free admin and Home Assistant integration, plus an
optional paid web app.

Alternative taglines:

1. A little more order. A lot less looking.
2. Your household, accounted for.
3. A home for the details of home.

Alternative subheads:

- Practical: "See what's in the pantry, which box holds the cables and where the drill belongs.
  Home Gnome brings your inventory, purchases and household to-dos together on a server you run."
- Technical: "Run your household inventory on your own server or NAS with one Docker image. The
  admin and Home Assistant integration are free, with a licensed web app for everyday use from
  your phone."
- Warmer: "Keep track of the things you share, the places you put them and the jobs that need
  doing. Home Gnome gives those everyday details a home on your own server."

## Site map

Main navigation stays short: **Product · Home Assistant · Plans · Docs** + the primary CTA.
Secondary pages live in the footer. No thin per-feature pages: sections on Product first, a page
only when a topic earns one.

| Page | Purpose | Primary CTA | Content |
| --- | --- | --- | --- |
| Home | explain the product, establish usefulness | Get early access / Download free | blocks + selected ACF features, plans, FAQs |
| Product | tour things, places, purchases, owners, to-dos | See the web app | block narrative + ACF feature records |
| Web app | the paid everyday interface | Get web app updates / Request a licence | blocks + ACF features, labelled screenshots |
| Home Assistant | free sensors, actions, NFC blueprints | Read integration setup | blocks + ACF integration details |
| Integrations | Alexa and other connections, availability marked | Read setup instructions | ACF integration records + block intros |
| Plans & licensing | free vs paid, clearly | Download free / Request a licence | ACF plan comparison + licensing FAQ |
| Get started | Docker install and prerequisites | Open installation guide | blocks; release and download facts from ACF |
| Docs | install, concepts, everyday use, troubleshooting | Open the relevant guide | plain block articles |
| Release notes | actual changes and upgrade notes | Read update instructions | ACF release metadata + block body |
| FAQ | purchasing, hosting, product questions | Contact us | ACF FAQ records |
| Contact | questions and support routing | Send message | blocks + Gravity Forms |
| Early access / Licence request | conversion pages | Submit request | blocks + Gravity Forms |
| About | why it was built | Explore the product | plain blocks |
| Privacy / Licence terms | the actual policies | contextual | plain blocks |

## Homepage, section by section

These are child-theme patterns built from native blocks (Spectra One, Spectra, core). Custom
CSS is a last resort; where a native block cannot express a section, it becomes an ACF block
(block.json + PHP render template).

| Section | Says and shows | CTA | Built with |
| --- | --- | --- | --- |
| Header | logo, compact nav, one primary action | Get early access | header template part: Site Logo, Navigation, Buttons |
| Hero | tagline + subhead; a real shelf or illustrated scene beside a clearly labelled paid web-app preview; three proof chips (one Docker image · home server or NAS · free admin + Home Assistant) | Get early access · See how it works | Spectra Container, two columns; Heading, Paragraph, Buttons, Image |
| Things & places | "From the pantry to the back of the garage." Garage → Shelf 2 → Tool tote, and the tote's contents | Explore things & places | two-column Container; Image; selected ACF feature |
| Counts & individual things | "A case of cans. A drill with a name." an opened case with 9 of 12 left vs a drill with nickname, serial, owner | See how inventory works | two-column feature pattern, small illustrative screen crops |
| Purchases & ownership | "Keep the story with the thing." where bought, price, receipt; a gift and its owner | Explore purchases & ownership | media/text pattern; ACF feature selection |
| Household to-dos | "The things to do belong here, too." a short Today list, a completed task with who did it | Explore household to-dos | Container; Heading; Image; text link |
| Self-hosting & connections | "Runs at home. Fits how you use it." one Docker image; free HA sensors, actions, NFC blueprints; Alexa as a separately described integration | Check installation requirements · Home Assistant setup | three-column Container; ACF integration summaries |
| Free and paid | "Start with the free tools. Add the everyday web app." two columns, named inclusions, no invented price | Get the free edition / Get web app updates | ACF plan-comparison block |
| FAQ | hosting requirements, free vs paid, open-source status, remote access, external services, planned mobile app | Read all FAQs | ACF-rendered native `<details>` |
| Closing CTA | "Start with one shelf." add a place, record a few things, label it | Get early access / Download free | Group pattern + Buttons |
| Footer | docs, releases, contact, policies, product updates | Subscribe | footer template part; Gravity Forms block |

Responsive: hero copy before the visual on phones; captions and plan labels always kept;
feature groups go 3 → 2 → 1 columns; nothing essential in hover states or carousels.

## Visual directions (round 1)

ChatGPT's recommendation: build **A** as the main site, borrow **B**'s small illustrations for
onboarding and FAQs, use **C**'s clarity for Docs, Get started and Plans. Comps are in
`comps/` (screen captures of the thread's images; the originals are in the thread).

### A — A helpful house

An approachable, practical product website grounded in real household spaces.

- Type: **Manrope** (headings) / **DM Sans** (body)
- Mascot: small house-and-gnome mark in the logo; an occasional small illustration at the
  closing CTA or a form confirmation
- Imagery: real shelves, labelled totes, pantry cupboards and tools, paired with tight app
  crops showing one useful action
- Layout: asymmetric split hero, generous whitespace, softly rounded images, alternating quiet
  section backgrounds
- Why: connects the technical product to everyday usefulness and keeps the existing
  teal-and-coral identity

### B — The household field guide

A warm, useful handbook for the details of home.

- Type: **Fraunces** / **Source Sans 3**
- Mascot: more literal: a small gnome labelling a box or checking a list, in one or two
  illustrations, not every section (ChatGPT itself says to shrink it from the comp)
- Imagery: ink-and-wash household illustrations, restrained paper tones, clearly framed
  product screenshots
- Layout: editorial headings, thin rules, numbered sections, fewer rounded cards
- Why: the most memorable identity; organisation feels approachable

### C — Home infrastructure

A precise, well-documented tool that happens to serve a household.

- Type: **Space Grotesk** / **IBM Plex Sans**
- Mascot: abstract roof/hat mark; a fuller gnome on About or confirmation screens
- Imagery: product screenshots lead, with a real NAS, labels and household objects; sparse,
  factual diagrams
- Layout: strong alignment, thin rules, restrained corners, clear technical facts
- Why: gives self-hosters confidence without turning the site into a server dashboard

### Palettes, mapped to Spectra One's theme.json slots

| Slot (use) | A | B | C |
| --- | --- | --- | --- |
| primary (links, main buttons) | #086B67 | #365E52 | #175B70 |
| secondary (supporting accent) | #E88D79 | #B6644C | #C57A5A |
| heading | #203835 | #2E342E | #1D2C38 |
| body | #4E625D | #5D6256 | #52616C |
| background (page canvas) | #FFFCF7 | #F7F1E5 | #F7FAFC |
| surface (alternating sections) | #EAF2ED | #E8E5D7 | #E7EEF3 |

Spectra One's remaining slots repeat these: foreground → primary, tertiary → surface,
quaternary → background, neutral → body, outline → surface (stronger borders on controls).
Spectra One's default button hover uses `secondary`: override it with a dark colour so white
text never lands on pale coral.

Shared layout tokens: content width ~720px, wide 1200px; body 18px / 1.6; hero heading fluid
40–72px, section heading 30–44px; spacing scale 8, 16, 24, 32, 48, 64, 96px; section spacing
80–96px desktop, 40–56px phone; Google Fonts served locally from `assets/fonts/`, the same
tokens in editor and front end.

## Forms (Gravity Forms)

| Form | Fields | Where |
| --- | --- | --- |
| Early access | email (required); name; interest checkboxes: Inventory, Home Assistant, To-dos; server/platform; separate product-news opt-in | its own page, linked from the hero and closing CTA |
| Contact | name, email, topic, message; if Support: product version, installation platform (conditional logic) | Contact |
| Licence request | name, email, edition; request type: New licence / Existing licence help; message; for existing help: purchase email or order reference | its own page, linked from Plans |
| Newsletter | email, explicit consent | footer or Updates page |
| Purchase (later, once terms are settled) | edition, email, billing fields, final price, agreement to licence terms, payment through a supported add-on | Purchase page |

Inline confirmations and thank-you pages; no newsletter popup; the free download does not
require a signup unless that is a deliberate policy. A form submission is not a licence system:
until licence issuance exists the action stays "Request a licence".

## ACF field groups

Editorial writing stays in blocks; repeated product facts live in ACF so the site never becomes
a second page builder. Availability and edition are separate fields ("planned" and "paid" mean
different things). Licence keys and purchase records never appear in marketing fields.

| Field group | Fields | Applies to |
| --- | --- | --- |
| Product availability | release_stage; primary_cta_label; primary_cta_url; download_url; installation_guide_url; licence_request_url; pricing_status | options page |
| Feature details | short_title; summary; feature_area; availability (Available / Preview / Planned); edition (Free / Paid / To confirm); benefits (repeater); documentation_link | `hg_feature` |
| Product media | image; caption; interface (Admin / Web app / Home Assistant); illustrative (bool); version_shown; availability_label | reusable screenshot block |
| Integration details | summary; availability; edition; capabilities (repeater); requirements (repeater); setup_url; external_service_notes | `hg_integration` |
| Plan details | plan_name; summary; price_status; amount (nullable); currency; billing_term (nullable); inclusions (relationship → features); licence_summary; cta_label; cta_url; display_order | `hg_plan` |
| FAQ details | question; answer; topic; related_features; display_order | `hg_faq` |
| Release details | version; release_date; channel; highlights (repeater); minimum_requirements; download_url; upgrade_notes | `hg_release` (details in the block body) |
| Homepage selections | ordered relationships: featured_features, featured_integrations, displayed_plans, featured_faqs | front page |
| Documentation metadata | topic; applies_to_version; last_reviewed; prerequisites; related_guides | docs pages or `hg_doc` |
| Form placement | gravity_form_id; intro; context_label | reusable form-section block |

Structured blocks register through `block.json` with PHP render templates (ACF blocks); no
JavaScript application.
