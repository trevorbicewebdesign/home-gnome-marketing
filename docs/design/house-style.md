# Home Gnome house style (round 2, consolidated)

The one direction the site is built in: Direction A ("A helpful house") as the base, Direction
B's ink illustrations in a few warm moments, Direction C's precision on Docs, Get started and
Plans through tighter spacing and simpler composition, never a different palette or font. Comps:
`comps/round2-*.png` (captures; originals in the ChatGPT thread). The token values below are
the build specification; the comps are concepts, not measurements.

Build rule (the owner's): native Spectra One, Spectra and core blocks, block styles and
theme.json tokens. Custom CSS is a last resort. A custom block (ACF, block.json + PHP render
template) only where a native block cannot express something, and then it renders real core
blocks, never bespoke HTML that needs a stylesheet.

## Palette: every Spectra One theme.json slot

| Slot | Hex | Role |
| --- | --- | --- |
| primary | #086B67 | main buttons, links, active navigation |
| secondary | #E88D79 | coral accents; occasional secondary button with dark text |
| heading | #203835 | headings; the only dark section colour (closing CTA, footer) |
| body | #4E625D | paragraphs |
| background | #FFFCF7 | warm page background |
| tertiary | #EAF2ED | sage feature sections, onboarding panels |
| quaternary | #FAE8E2 | blush purchases/ownership section, occasional callouts |
| surface | #FFFFFF | cards, forms, screenshot surrounds |
| foreground | #054B48 | button hover, stronger interactive emphasis |
| outline | #CBD7D1 | decorative borders, separators |
| neutral | #61706B | captions, supporting labels, stronger input borders |

Buttons (contrast measured by ChatGPT: primary 6.2:1, its hover 9.7:1, dark text on coral 5.1:1):

| Treatment | Background / text | Hover background / text |
| --- | --- | --- |
| Primary | primary / background | foreground / background |
| Secondary | secondary / heading | quaternary / heading |
| On dark sections | background / foreground | tertiary / foreground |
| Text link | transparent / primary, underlined | transparent / foreground, underlined |

Core button colours and hover go in theme.json. Spectra Buttons use their native normal/hover
controls, saved in reusable patterns. On dark sections text is `background`, rules `neutral`.

## Typography

- **Manrope** headings, 700 (small card headings 600). **DM Sans** body 400; navigation, labels,
  buttons 600. Both hosted locally in `assets/fonts/`. Same fonts on Docs and Plans.
- Keep Spectra One's fontSizes slugs; fixed sizes get `"fluid": false`:

| Slug | Size | Fluid | Use |
| --- | --- | --- | --- |
| x-small | 14px | off | captions, metadata |
| small | 16px | off | navigation, buttons, form controls |
| medium | 18px | off | body, phones too |
| large | 22px | 20–22 | intro paragraphs, compact card headings |
| x-large | 28px | 24–28 | H3 |
| xx-large | 36px | 28–36 | section H2 |
| xxx-large | 44px | 32–44 | Docs, Plans, Get started H1 |
| xxxx-large | 64px | 40–64 | homepage hero H1 |

Line heights: hero H1 1.1; other headings 1.2; card headings 1.3; body and docs 1.6;
navigation, buttons, labels 1.4; captions 1.5. No manual heading line breaks.

## Spacing, layout, radius

| Spacing slug | Value | Use |
| --- | --- | --- |
| xxx-small | 4px | tiny label gaps |
| xx-small | 8px | icon/text, eyebrow/heading gaps |
| x-small | 16px | paragraph rhythm |
| small | 24px | card padding, phone gutters |
| medium | 32px | tablet gutters, compact sections |
| large | 48px | column gaps, tablet section padding |
| x-large | 64px | desktop section padding |
| xx-large | 96px | optional generous hero spacing |

Layout: wide 1200px; reading 720px; forms 640px; gutters 32px desktop/tablet, 24px phone;
section padding 64/48/32px; feature-column gap 48/32/24px; card grid gap 24px; buttons 12px
vertical, 24px horizontal, 44px minimum touch target.

`settings.custom.borderRadius`: xxSmall 4px (inset labels), xSmall 6px (buttons, inputs),
small 8px (cards, accordion items), medium 12px (photos, product images), large 16, xLarge 20,
xxLarge 24 (reserved), full 999px (circular icons). These are variables, not a picker in every
block: reference them in theme.json block styles, and where a Spectra control takes only a
number, type the value and keep it in the pattern.

## Homepage: native-block mapping

Every full-width section = outer Spectra Container (background) → inner Container capped at
1200px, with Spectra's native responsive direction, width, padding and gap controls. Core
Heading, Paragraph and Image wherever they do the job.

| Section | Blocks | Settings and responsive behaviour | Custom block? |
| --- | --- | --- | --- |
| Header | header part → Container; Site Logo, Navigation; Spectra Buttons | background; 16px vertical padding; row, space-between; native Navigation overlay on phone with the early-access link inside it | no |
| Hero | Container → two Containers; Heading, Paragraph, Image; Spectra Buttons | background; 50/50; 48px gap; H1 xxxx-large; text before image on tablet/phone; buttons full-width on phone; image radius 12px; the hero visual is one composed image (shelf + phone), caption as live text below | no |
| Hero facts | Container; three Groups (icon Image + Paragraph) | three columns → vertical list on phone; 16px gap; icons 24–32px; text small | no |
| Things & places | Container; Heading, Paragraph, Image; linked Paragraph | tertiary; two equal columns; photo radius 12px; phone: copy, link, photo | no |
| Counts & individual things | Container; Heading, Paragraph; two Groups (Image + caption) | surface; text/media columns; two example images stack on phone; captions "9 of 12 cans left", "Workshop drill · serial and owner" | no |
| Purchases & ownership | Container; Heading, Paragraph, Image + caption | quaternary; two columns; one Image, 12px radius; caption "Illustrative paid web app" | no |
| Household to-dos | same media/text pattern | tertiary; a short Today list | no |
| Hosting & connections | Container; three Groups (Image, Heading, Paragraph, links) | surface; 3 → 1 columns; 32px icons; 24px gaps; Docker, Home Assistant, Alexa described separately | layout no; ACF adapter for shared records |
| Free and paid | core Columns → Group, Heading, Paragraph, List, Buttons | background; two cards, surface fill, 1px outline, 8px radius, 24px padding; stack on phone | ACF plan block for shared plan records |
| FAQ | core Details; Heading, Image | surface; 8px gaps; Details 16px padding, 1px outline, 8px radius; all closed; gnome beside the intro, never inside the controls | ACF FAQ block for shared records |
| Closing CTA | Container; Heading, Paragraph; Spectra Buttons | heading background; background text; centred; 64/48/32px padding; light button treatment | no |
| Footer | footer part → Container; Site Logo, Navigation, Paragraph; Gravity Forms block | same dark background; 3 → 1 columns; newsletter with visible label; email and submit stack on phone | no (Gravity Forms is the form block) |

No section needs a custom block for its appearance. Three ACF blocks exist only to render shared
records as native core blocks:

| Block | Renders |
| --- | --- |
| `home-gnome/feature-list` | selected feature/integration records as core Groups or Columns with Image, Heading, Paragraph, links |
| `home-gnome/plan-comparison` | the selected plans: availability/pricing text, feature lists, CTAs, as core Columns, Groups, Lists, Buttons |
| `home-gnome/faq-list` | selected FAQ records as core Details blocks |

Their templates output real core blocks with supported attributes so the normal block styles
load. (Alternative: synced patterns with the content typed in, and no adapters; then ACF stops
being the source of truth for those sections.)

## Plans, Docs, Get started: the precise register

| Page | Native construction | Treatment |
| --- | --- | --- |
| Plans | Heading/Paragraph; plan-comparison block; Container licensing notice; FAQ block; Gravity Forms | H1 44px max; 8px card radius; clear feature lists; no mascot, no lifestyle imagery |
| Docs landing | Container intro; two-column "Start here" panel; ordered List; three-column guide grid of Groups (Image, Heading, linked Paragraph) | 24px card padding; 1px borders; teal links; 3/2/1 columns |
| Get started | Heading, Paragraph, List, Image, Code, Details inside Containers | 720px reading width; numbered steps; prerequisites before commands |

Docs landing is fully native (curated navigation); a core Query Loop lists latest releases.

Forms: Gravity Forms' Orbital theme with its block styling controls: inherited fonts, 6px input
radius, surface inputs, neutral borders, heading-coloured labels, teal submit. Nothing forced
through CSS; keep the native arrangement when a detail has no control.

## Gnome mark

Works at favicon size before it becomes an illustration: a simple teal house outline (pitched
roof, two walls, short base), a coral triangular gnome hat inside with a slight lean, a small
round nose under the hat's edge, negative space suggesting face and beard. No eyes, fingers,
seams, windows or chimney in the small mark; the outer house roughly square; consistent line
weight. Full-colour, single-colour and reversed versions. Paired with a Manrope wordmark.

The fuller gnome appears in: first-run/onboarding explanations, the homepage FAQ intro,
early-access and newsletter confirmations, a restrained 404 or real empty state. Never beside
prices, payment fields, licence conditions, error messages or install commands; never a
floating assistant.

## Ink illustration rules (from B)

Stroke in dark teal or heading, simple slightly imperfect outlines; mostly outline with small
coral and sage fills; transparent background; 80–120px desktop, 64–80px phone; one spot
illustration per page, two at most when they serve different purposes; homepage: one gnome near
the FAQ; onboarding: a labelled box, shelf or label maker may replace the gnome; Docs: no
decorative gnomes, instructional drawings only; Plans: none; empty moments: one small drawing
with a useful next action. Inserted with the core Image block; decorative ones get empty alt
text, explanatory ones meaningful alt text.
