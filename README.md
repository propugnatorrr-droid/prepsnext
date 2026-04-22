# PrepsNext Athlete Profiles — WordPress Plugin

**Version:** 1.0.6  
**For:** prepsnextmag.com  
**Supports:** Basketball & Football  

---

## 📦 Installation

1. Upload the `prepsnext-athlete-profiles` folder to `/wp-content/plugins/`
2. Activate via **Plugins → Installed Plugins**
3. Go to **Athletes → Settings** to configure
4. Add your first athlete at **Athletes → Add New Athlete**

---

## ✅ Features Implemented

### Admin Backend
- **Custom Post Type** `pn_athlete` — dedicated athlete profile post type with archive at `/athletes/`
- **11 Meta Box Sections** on every athlete profile:
  - 🏆 Prospect Status & Rankings (Top Prospect, Stock Riser, Committed, etc.)
  - 👤 Basic Info (first/last name, city, DOB, bio, hero image, headshot, **📧 contact email**, **📞 contact phone**)
  - 🏫 School & Team Info (school name, location, logo, team, jersey, positions, conference)
  - 📏 Physical Measurements (height, weight, wingspan, hand size, dominant hand/foot, vertical, 40-yard dash, bench press, shuttle)
  - 📚 Academic History (GPA, SAT, ACT, intended major, NCAA eligibility, honors)
  - 📅 Career History — repeatable season rows (year, grade, school, position, jersey, height/weight, win/loss record, league record, national/state rank, notes)
  - 📊 Performance Stats — basketball stats (PPG, RPG, APG, SPG, BPG, FG%, 3P%, FT%) + football stats (passing, rushing, receiving, defensive stats)
  - 🎓 Recruiting & College Interests (scholarship offers, college interests, committed school, NLI signing, college logo grid up to 8 schools)
  - 🎬 Media Gallery — unlimited photos/videos with titles, view counts, YouTube/Vimeo/direct video support, drag-to-reorder
  - 📱 Social Media (Instagram, Twitter/X, TikTok, YouTube, Facebook, Hudl, Rivals, 247Sports, On3, ESPN)
  - 📰 Related Blog Posts (auto-tag linking + manual post search/link)

### Custom Taxonomies (auto-seeded with defaults)
- `pn_sport` — Basketball, Football
- `pn_position` — Basketball (PG, SG, SF, PF, C) + Football (QB, RB, WR, TE, OL, DE, etc.)
- `pn_state` — All 50 US states + DC
- `pn_class_year` — Current year through +6 years + Graduated
- `pn_school_tax` — Schools
- `pn_college_interest` — College interests

### Frontend Profile Page
- **Dark sports card hero** with lime/neon accent matching PrepsNext brand
- **Athlete name** rendered in a **single horizontal line** at the top of the card — first name in white, last name in lime. Zero extra top spacing; theme h1 margins suppressed.
- **Contact info pills** — email and phone appear as clickable `mailto:` / `tel:` pills in the hero card when set
- **Hero action photo** with glow effect
- **School block** with logo, name, positions, jersey
- **Quick stats bar** (HT, WT, POS, JERSEY)
- **Rankings panel** — position rank, state rank, national rank, stock riser badge
- **Tab navigation** — Overview, Media, Career History, Stats, Recruiting, Academics, News
- **Media gallery grid** — asymmetric layout, video play modal (YouTube/Vimeo embedded)
- **Career timeline** — season cards sorted newest-first with full details
- **College logos grid** for school interests
- **Social media links** with brand colors
- **Related news articles** — auto-pulls from athlete tag + manually linked posts
- **Sidebar** — contact CTA, rankings panel, quick info card
- **Video modal** — YouTube/Vimeo/direct MP4 support
- Schema.org JSON-LD markup for SEO

### Archive / Directory Page
- Filter bar (sport, state, class year, position, search)
- Responsive athlete card grid
- Prospect status badges (Top Prospect, Stock Riser, etc.)
- Pagination

### Admin Tools
- **Rankings Manager** page — sortable table of all ranked athletes by sport
- **Dashboard Widget** — total athletes, by sport, top prospects count
- **Settings Page** — accent color, background color, custom CSS, contact email, features toggle
- **Import/Export** — CSV export of all athlete data
- **Admin List Columns** — sport, class year, state, school, ranking, status badges

### Sidebar Widget — New Athletes
- **Widget name:** `New Athletes`
- Add via **Appearance → Widgets** (or the block-based Widget Editor)
- **Displays** a vertical list of the most recently published athlete profiles
- **Each row shows:** circular mugshot/headshot, full name, and sport (with emoji icon)
- Falls back gracefully if no photo is set (shows sport emoji placeholder)
- **Configurable options in the widget admin panel:**
  | Option | Default | Range |
  |---|---|---|
  | Title | `New Athletes` | Any text |
  | Number of athletes to show | `5` | 1 – 20 |
  | Filter by sport | All Sports | All Sports / 🏀 Basketball / 🏈 Football |
- "View All Athletes →" footer link to the athlete archive
- Hover effects: lime accent on name, border glow on photo, animated arrow
- CSS variables inherit the PrepsNext brand accent color (`--pn-accent`)

### Shortcodes
| Shortcode | Description |
|---|---|
| `[prepsnext_feed]` | **Main social feed** (auto-created page: `/prepsnext-feed/`) ✨ |
| `[prepsnext_thread_login]` | Athlete login page ✨ |
| `[prepsnext_thread_register]` | Athlete sign-up page ✨ |
| `[prepsnext_athlete id="123"]` | Single athlete card |
| `[prepsnext_athlete id="123" style="mini"]` | Inline mini badge |
| `[prepsnext_athlete id="123" style="inline"]` | Compact inline card |
| `[prepsnext_athletes sport="basketball" limit="8"]` | Athlete grid |
| `[prepsnext_rankings sport="basketball" limit="10"]` | Rankings table |
| `[prepsnext_top_athletes limit="4" sport="basketball"]` | Top prospects showcase |
| `[prepsnext_register]` | Athlete registration form |
| `[prepsnext_claim]` | Profile claim form (logged-in users) |

### Content Tagging
- Add `[[athlete:slug]]` anywhere in blog post content to auto-link to an athlete profile
- Set an **athlete tag slug** on any profile — all blog posts with that tag auto-appear in the News tab

### User System
- Athletes can register via `[prepsnext_register]`
- Athletes can claim their profile via `[prepsnext_claim]`
- WP user admin shows athlete linking, sport, and verified status
- Admin approval workflow for profile claims
- Email notifications to admin on new registrations and claims

---

## 🗂 File Structure

```
prepsnext-athlete-profiles/
├── prepsnext-athlete-profiles.php   ← Main plugin file
├── includes/
│   ├── class-prepsnext-cpt.php          ← Custom Post Type
│   ├── class-prepsnext-taxonomies.php   ← Taxonomies (sport, state, etc.)
│   ├── class-prepsnext-metaboxes.php    ← All admin meta boxes
│   ├── class-prepsnext-admin.php        ← Settings, rankings, dashboard widget
│   ├── class-prepsnext-ajax.php         ← AJAX handlers + CSV export
│   ├── class-prepsnext-frontend.php     ← Template overrides, schema, filters
│   ├── class-prepsnext-shortcodes.php   ← All shortcodes
│   ├── class-prepsnext-widget.php       ← New Athletes sidebar widget ✨
│   ├── class-prepsnext-threads-db.php   ← Threads DB schema installer ✨
│   ├── class-prepsnext-threads.php      ← Threads core engine ✨
│   ├── class-prepsnext-threads-ajax.php ← Threads AJAX endpoints ✨
│   └── class-prepsnext-user-profile.php ← User registration + profile claim
├── templates/
│   ├── single-athlete.php      ← Profile page template
│   ├── archive-athlete.php     ← Athlete directory template
│   ├── threads-feed.php        ← Social feed template ✨
│   ├── threads-login.php       ← Login page template ✨
│   └── threads-register.php    ← Registration template ✨
├── assets/
│   ├── css/
│   │   ├── profile.css    ← Frontend profile styles
│   │   ├── admin.css      ← Admin panel styles
│   │   ├── forms.css      ← Shortcode + form styles + widget CSS
│   │   └── threads.css    ← Social feed UI ✨
│   └── js/
│       ├── profile.js     ← Tab navigation, video modal, animations
│       ├── admin.js       ← Media uploader, season rows, related post search
│       └── threads.js     ← Social feed interactivity ✨
└── README.md
```

---

## 🔗 Key URLs

| Page | URL |
|---|---|
| Athlete Archive | `/athletes/` |
| Single Profile | `/athletes/athlete-slug/` |
| Admin Athletes | `/wp-admin/edit.php?post_type=pn_athlete` |
| Settings | `/wp-admin/edit.php?post_type=pn_athlete&page=prepsnext-settings` |
| **Social Feed** | `/prepsnext-feed/` ✨ |
| **Athlete Login** | `/prepsnext-login/` ✨ |
| **Athlete Register** | `/prepsnext-register/` ✨ |
| **User Approval** | `/wp-admin/users.php` → click "✅ Approve for Threads" ✨ |
| Rankings | `/wp-admin/edit.php?post_type=pn_athlete&page=prepsnext-rankings` |
| Import/Export | `/wp-admin/edit.php?post_type=pn_athlete&page=prepsnext-import-export` |

---

## 📤 Bulk Import — Quick Start

1. Find the file **`prepsnext-athletes-import-sample.csv`** in the plugin root
2. Go to **Athletes → Import / Export** in WordPress admin
3. Click **Choose CSV file**, select the CSV, click **⬆️ Import Athletes from CSV**
4. A success notice will confirm how many athletes were imported

### CSV column reference

| Column | Required | Notes |
|---|---|---|
| `first_name` | ✅ | |
| `last_name` | ✅ | |
| `sport` | ✅ | `Basketball` or `Football` |
| `class_year` | | e.g. `Class of 2026` |
| `state` | | Full state name e.g. `Florida` |
| `city` | | |
| `school_name` | | |
| `school_location` | | e.g. `Orlando, FL` |
| `team_name` | | e.g. `Panthers` |
| `positions` | | Comma-separated e.g. `PG, SG` |
| `jersey_number` | | |
| `conference` | | |
| `division` | | e.g. `Class 6A` |
| `height` | | e.g. `6'4"` |
| `weight` | | e.g. `185 lbs` |
| `prospect_status` | | `top_prospect` / `featured` / `stock_riser` / `committed` / `signed` |
| `national_rank` | | Number only |
| `state_rank` | | Number only |
| `committed_to` | | School name |
| `bio` | | Plain text |
| `gpa` | | e.g. `3.8` |
| `sat_score` | | |
| `act_score` | | |
| `intended_major` | | |
| `ncaa_eligible` | | `1` or `yes` |
| `college_offers` | | Pipe-separated: `Florida\|FSU\|Miami` |
| `college_interests` | | Pipe-separated |
| `stat_ppg` … `stat_ft_pct` | | Basketball stats |
| `stat_pass_yards` … `stat_ff` | | Football stats |
| `social_instagram` … `social_on3` | | Full URLs |

---

## 🎨 Theme Override

Copy any template file to your theme to override:

```
your-theme/
└── prepsnext/
    ├── single-athlete.php
    └── archive-athlete.php
```

---

## 🔄 Changelog

### v1.0.6 — Critical Fix + PrepsNext Threads (2025-04-21)
- **🐛 CRITICAL FIX:** Resolved "critical error" caused by three fatal PHP issues introduced in v1.0.5/1.0.6 Threads build:
  1. `wp_redirect()` + `exit` called inside `ob_start()` / shortcode context in `sc_login()` and `sc_register()` — caused "headers already sent" fatal error. **Fix:** Moved redirect logic to the `template_redirect` action hook (`maybe_redirect_logged_in()`); shortcodes now return a safe HTML link instead.
  2. Login and registration POST forms used `wp_redirect()` + `exit` inside template files loaded by shortcodes — same fatal. **Fix:** Forms now POST to `admin-post.php` via `admin_post_nopriv_pn_thread_login` / `admin_post_nopriv_pn_thread_register` actions, which run before any output.
  3. `register_pages()` used `get_page_by_path()` + `wp_insert_post()` on every single `init` hook — expensive DB hit and potential infinite loops. **Fix:** Moved to `wp_loaded`, guarded by a 1-hour transient (`pn_threads_pages_created`), and skipped during AJAX/cron/REST requests.
  4. `PrepsNext_Threads_DB::install()` (`dbDelta`) was running on every AJAX call. **Fix:** Guarded with `wp_doing_ajax()` check.
- **New:** **PrepsNext Threads** — full sports social feed (Threads + Reddit mashup) with:
  - Feed page (`[prepsnext_feed]`), Login (`[prepsnext_thread_login]`), Register (`[prepsnext_thread_register]`)
  - Post threads (text + image, max 5 MB, auto-cropped to 1080×1080)
  - Comments with threaded replies, image attachments, like/delete
  - ❤️ Like, 🔁 Repost (plain or quote), 💬 Comment, 🔗 Share/Copy link
  - 👤 Follow / Unfollow athletes
  - 🔔 In-app notifications (likes, comments, reposts, follows)
  - Inline status badges next to usernames (⭐ Top Prospect, 🔥 Featured, 📈 Rising, ✅ Committed, 📝 Signed)
  - Guest / pending users can read but NOT interact
  - Admin one-click approval at **Users** screen with email notification to athlete
  - Right sidebar: Top Prospects widget + Rising Athletes widget
  - Infinite scroll feed with For You / Following / Basketball / Football tabs
  - Thread detail modal (click any thread to expand with full comment section)
  - Repost modal with Quote option
  - Dark/neon-lime design matching PrepsNext brand
- **New:** 5 custom DB tables: `pn_threads`, `pn_thread_comments`, `pn_thread_likes`, `pn_thread_reposts`, `pn_thread_follows`, `pn_notifications`

### v1.0.5 (2025-04-21)
- **New:** **New Athletes sidebar widget** (`PrepsNext_New_Athletes_Widget`) — vertical list with circular mugshot, name, and sport. Configurable count (1–20) and optional sport filter. "View All Athletes" footer link. Hover animations with PrepsNext lime accent.
- **New:** Widget CSS added to `assets/css/forms.css` (`.pn-naw-*` classes, CSS-variable-aware, light-theme safe).
- **New:** Full CSV import engine — `import_athletes_csv()` in `class-prepsnext-ajax.php` creates real `pn_athlete` posts with all meta fields, taxonomies, stats, and social links from a CSV upload.
- **New:** Import/Export admin page upgraded with result notices, column reference, and a proper file upload form.
- **New:** `prepsnext-athletes-import-sample.csv` — 100 pre-built athlete profiles (50 basketball / 50 football, spread across major states) ready to import.

### v1.0.4 (2025-04-20)
- **Fix:** Athlete name now renders on a **single horizontal line** with no extra top spacing, regardless of theme. Achieved via `inline-flex` with `flex-direction: row` on `.pn-athlete-name` + `.pn-name-first`/`.pn-name-last` set to `display: inline`. Top padding moved from `.pn-card-inner` into `.pn-name-banner` so the name sits flush. Theme `h1` top-margin neutralised inside `.pn-profile-wrapper`.
- **Fix:** Email and phone fields now **save correctly** — `pn_contact_email` / `pn_contact_phone` added to the `$text_fields` list in `save_meta()`. Email additionally re-sanitised with `sanitize_email()`.
- **New:** Contact info pill styles (`.pn-contact-pill`, `.pn-pill-email`, `.pn-pill-phone`) added to `profile.css`.
- **Fix:** Responsive breakpoints (≤900 px, ≤600 px) updated to preserve zero top-padding on `.pn-card-inner`.

### v1.0.2 (2025-04-20)
- CPT registration timing fixed (loads on `plugins_loaded`)
- Activation hook flushes rewrites after CPT is registered
- Auto-flush on plugin version change

### v1.0.0 – v1.0.1
- Initial release with full admin meta boxes, frontend profile template, archive, shortcodes, user system, AJAX search, CSV export

---

## 📝 Recommended Next Steps

1. **Club Teams** — Add a repeatable meta box for AAU/club team history
2. **Video Highlights Embed** — Embed a featured Hudl reel directly in the hero
3. **Player Comparison Tool** — Side-by-side comparison of two athletes
4. **Offer Tracker** — Public timeline showing offer dates
5. **User Dashboard** — Front-end dashboard for claimed profiles to self-update
6. **Email Newsletters** — Mailchimp integration for "New Profile Alert" by sport/state
7. **Notification System** — Notify users when a new athlete from their followed state is added
8. **SEO Sitemap** — Automatic sitemap generation for athlete profiles
9. **Advanced Search** — AJAX-powered live search across athlete profiles
10. **Leaderboard Widgets** — Sidebar widgets for top-ranked players by class/position

---

## ⚙️ Settings Reference

Located at: **Athletes → Settings**

| Setting | Default | Description |
|---|---|---|
| Accent Color | `#AAFF00` (Lime) | Brand accent color for profiles |
| Background Color | `#111111` | Profile page background |
| Default Sport | Basketball | Pre-selects sport on new profiles |
| Archive Per Page | 24 | Athletes shown per archive page |
| Show Contact Button | ✅ | Show contact CTA on profiles |
| Enable Athlete Registration | ✅ | Allow athlete sign-ups via shortcode |
| Contact Email | admin email | Where contact/claim requests go |
| Custom CSS | — | Inject custom CSS site-wide |
