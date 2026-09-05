# Cloudflare Workers, not Vercel

The site deploys to Cloudflare Workers via `@opennextjs/cloudflare`. The non-obvious reason is licensing, not technology: Vercel's Fair Use Guidelines restrict the Hobby plan to non-commercial use, defining commercial usage to include both "advertising the sale of a product or service" and "receiving payment to create, update, or host the site". A paid-for travel company site trips both independently, so Vercel starts at $20/user/month. Netlify's free tier permits commercial use but its credit model caps production deploys at roughly 20 per month, which a scheduled rebuild alone would exceed.

Cloudflare's terms carry no non-commercial clause, and the free plan covers cron triggers, deploy hooks, KV and route handlers — so the site runs at zero recurring cost with room to move to $5/month if the 10ms CPU limit ever binds.

Their terms do prohibit signing up "on behalf of a third party", so the client owns the Cloudflare account with us added as a member.
