# Plans page and the business model on the site (round 3)

Decided by the owner on 2026-11-05: the whole product is **free to self-host**; the paid things
are a **Hosted** edition (a private instance per household, subscription, price not announced)
and a **native iOS/Android app** (one-time purchase for self-hosters; inclusion with Hosted is
proposed; planned, not shipped). This replaces the earlier "free admin, paid web app" split
everywhere on the site. The honest split is where it runs, not which screens you get. The
business plan behind it is the Claude Doc "Home Gnome business plan".

## Positioning carrying the model

Homepage headline stays **Know what you have. Find where it is.** The subhead now carries the
model: *Keep track of your things, places, purchases and household to-dos with Home Gnome. Run
the whole product free, forever, on your own server, or join the waitlist for a private instance
we manage.* Alternative line for other pages: *Your household, organised. Free to run yourself,
or hosted by us.*

Global replacements:

| Previous | Replace with |
| --- | --- |
| Free admin / paid web app | complete product in both hosting options |
| Illustrative paid web app (caption) | Illustrative app screen |
| Request a licence | Download free · Join the hosted waitlist · Get notified, by context |
| Licence key activation | removed |
| Plans & licensing | Plans & hosting |
| Get early access (main CTA) | Download free (until the download is public: Get early access) |

## Plans & hosting page

H1: **Run it yourself, or let us host it.** Intro: *The same Home Gnome, wherever it runs.
Choose your own server or a private instance managed by us.* Then: *Two hosting options. One
optional native companion app.* (so the third column does not read as a third server edition).

| | Self-hosted | Hosted | Native app |
| --- | --- | --- | --- |
| Status | Available | Coming | Planned |
| Lead | Free, forever | Price to be announced | One-time purchase for self-hosters |
| Where it runs | your server or NAS | a private instance for your household | your iOS or Android device |
| Includes | server, admin, web app, Home Assistant, Alexa | the same complete product, plus managed backups, updates and support | barcode and NFC scanning; connects to either edition |
| Operation | one Docker image; you manage backups and updates | a yourhouse.homegnome address (illustrative); monthly or yearly | planned app-store distribution |
| Native app | separate purchase when available | inclusion for the whole household proposed | price unannounced |
| CTA | Download free | Join the hosted waitlist | Get notified |

Under the columns: **The product is the same. The hosting is different.** Inventory, places,
purchases, owners and to-dos are in both hosting options; choose who runs the server.

Terms notice: **Free to self-host. Proprietary code.** The complete self-hosted product is free
to use and needs no licence key. Hosted subscriptions and app-store purchases have their own
terms (link Software terms, Hosted terms, Privacy once they exist). No lifetime, unlimited-seat,
refund or cancellation promises until the terms are written.

FAQ entries (waitlist-stage answers; resolve data, migration and cancellation before taking
Hosted payments):

| Question | Answer |
| --- | --- |
| Is Home Gnome open source? | No. The code is proprietary. The complete self-hosted product is free to use, forever, without a licence key. |
| What happens to my data on Hosted? | Your household's records live in its private instance, with backups managed by us. Hosting location, access, retention and deletion details are not yet announced. |
| Can I move from Hosted to self-hosted? | Both run the same product. A supported export and migration process is not yet announced. |
| What will the native app cost? | A one-time app-store purchase for self-hosters. Pricing unannounced; inclusion with Hosted proposed. |
| What about other people in my household? | Hosted is one private instance per household. Native app access for everyone in it is proposed; purchase and sharing details are not final. |
| Is the native app required? | No. The browser web app is included with both hosting options; the app adds barcode and NFC scanning. |
| What happens if I cancel Hosted? | Cancellation, export and retention terms are not yet announced. |

Native-block mapping:

| Section | Blocks and settings |
| --- | --- |
| Intro | Spectra Container; Heading, Paragraph; background; 720px; H1 xxx-large |
| Three columns | three nested Containers; Heading, Paragraph, Icon List or core List, Buttons; surface, 1px outline, 8px radius, 24px padding; 3 columns → stacked |
| Status labels | Paragraph in a small Group; tertiary or quaternary background, heading text; always written out |
| Same-product statement | Container, tertiary; Heading, Paragraph; 24px padding |
| Terms notice | Group, Heading, Paragraph, linked text |
| FAQ | core Details, or the ACF FAQ adapter rendering core Details |
| Hosted waitlist | two-column Container: copy + Gravity Forms block; stacks on phone |
| Closing CTA, footer | the round-2 dark patterns |

The ACF plan-comparison adapter renders three records on Plans and the two hosting records on
the homepage. No new custom block, no custom CSS.

## Homepage sections that change (everything else as round 2)

- **Hero facts:** Complete product, free to self-host · One Docker image · Managed hosting
  coming. Main action Download free; secondary See how it works; a quiet "Prefer Hosted? Join
  the waitlist" link.
- **Hosting & connections** → heading **One Home Gnome. Connected to your household.** Columns:
  *Your server or ours* (run it on your server or NAS, or join the waitlist for a managed
  private instance); *Home Assistant* (stock sensors, actions and NFC blueprints with either
  hosting option); *Alexa* (where is, how many, "I used one"). Setup requirements live in the
  integration guides; never imply Hosted reaches every local device automatically.
- **Free and paid** → **Run it yourself, or let us.** *The whole product is free on your own
  server. Prefer to leave the hosting to us? Join the waitlist for a private instance with
  backups, updates and support.* Two equal cards (Self-hosted, Hosted) with the Plans inclusions
  and status labels. Below, a subordinate blush band: **A native app is on the way.** *Planned
  for iOS and Android, with barcode and NFC scanning. Works with either edition.* Supporting
  line: one-time purchase for self-hosters; inclusion with Hosted proposed. CTA Get notified.
  Container, icon Image, Heading, Paragraph, linked text; stacks on phones.
- **Closing CTA:** **Start with one shelf.** *Run Home Gnome free on your own server, or join the
  waitlist to let us take care of the hosting.* Buttons Download free · Join the hosted
  waitlist. Status line: Self-hosted: available · Hosted: coming.

## Gravity Forms (revised)

| Form | Fields | Placement and behaviour |
| --- | --- | --- |
| Hosted waitlist | email (required); name; current use: Self-hosting / Considering it / New here; separate checkbox for native-app notifications | Plans and a Hosted page; confirmation says "joined a waitlist", never that an instance or address is reserved |
| Native app notifications | email (required); platform: iOS / Android / Both; hosting preference: Self-hosted / Hosted / Undecided | app page or notification section; confirmation says the app is planned |
| Product updates (was Early access) | email, name; notification interests instead of edition/licence questions | the download never depends on it |
| Contact / support | existing fields; routing Self-hosted / Hosted / Native app | Contact |
| Newsletter | email, consent | footer; separate from service notifications |

Retire the licence-request form and its confirmations. Existing early-access subscribers keep
the scope of their original signup.

## ACF plan records (revised)

| Field | Self-hosted | Hosted | Native app |
| --- | --- | --- | --- |
| record_type | hosting | hosting | companion_app |
| edition | self_hosted | hosted | native_app |
| hosting | own_server | managed_private_instance | not_applicable |
| status | available | coming | planned |
| includes_app (select, not boolean) | separate_purchase | proposed_included | not_applicable |
| price_status | free_forever | unannounced | unannounced |
| billing_model | free | subscription | one_time |
| billing_intervals | | monthly, yearly | |
| price_amount | | | |
| cta_label | Download free | Join the hosted waitlist | Get notified |

Also: compatible_editions (app: Self-hosted and Hosted), platforms, app_inclusion_note,
household_terms_status, address_example, shared_feature_set (relationship to the one full
feature list, both hosting records), operational_inclusions (Hosted), cta_url or
gravity_form_id, display_order.

Rendering rules: free_forever → "Free, forever"; unannounced → "Price to be announced", never
$0; proposed_included → a written "Proposed" label; planned never produces a store button; both
hosting records inherit the same feature list. Remove licence-key fields, paid-web-app flags and
the old caption default.
