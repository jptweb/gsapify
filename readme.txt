== Description ==

GSAPify is a developer-focused Gutenberg block that makes it dead-simple to drop in custom GSAP animations without loading heavy libraries site-wide. Instead of wrestling with nag-ware plugins or manually pasting <script> tags into HTML blocks, GSAPify gives you three built-in code editors right in the block inspector:

  * **HTML** – your markup container  
  * **CSS**  – scoped styles for positioning, sizing, etc.  
  * **JavaScript** – your GSAP timeline, ScrollTrigger, or any custom script

Because it’s a **dynamic** block, GSAPify only enqueues the GSAP core (and any plugins you choose) on pages where you actually use the block—so your other pages stay lightning fast. It even ships with a “Hello, GSAPify!” variation so you can prototype in seconds.

Whether you’re a full-stack developer, front-end engineer, or just comfortable writing code, GSAPify gives you total control over your animations without the bloat. Perfect for adding scroll-based effects, intro tweens, or complex timelines, all managed cleanly through Gutenberg.

== Installation ==

1. Upload the `gsapify` folder to `/wp-content/plugins/` or install via the plugin ZIP.  
2. Activate **GSAPify** in **Plugins → Installed Plugins**.  
3. In the Block Editor, click **Add Block → Widgets → GSAPify Animation Helper**.  
4. Enter your HTML, CSS, and JS in the block settings and watch GSAP fire only where you need it.

== Frequently Asked Questions ==

= Do I need to enque GSAP =  
No, the whole reason I wanted this was so that I could just create a quick block on a blog post and simply fill in the fields necceassry and save the overhead of GSAP being loaded on every single website. Its not quite ready yet but this is my intiial commit and a preview of whats to come!

= I need GSAP plugins like ScrollTrigger, how do I load them? =  
As of now this plugin just enqueues the main gsap library from a CDN. I will add in more features later; but for now you would have to enque extra JS (which I know defeats the whole purpose of this being able to use without touching code, but it will get there eventually)

= Can I use this block multiple times per page? =  
Yes! Each instance has its own HTML/CSS/JS fields and will enqueue GSAP once.

== Changelog ==

= 0.1.0 =  
* Initial release of GSAPify Animation Helper block
