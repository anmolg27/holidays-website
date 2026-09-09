# Uttarakhand Tours Website

Next.js app deployed to Cloudflare Workers via `@opennextjs/cloudflare`. See `.scratch/uttarakhand-tours-site/spec.md` for the product spec and `docs/adr/` for architecture decisions.

## Local development

```
npm install
npm run dev
```

## Testing

```
npm test
```

## Cloudflare deployment

CI (`.github/workflows/ci.yml`) builds with `opennextjs-cloudflare` and deploys on push to `main`, or when the workflow is dispatched by hand. One-time setup:

1. The client creates a Cloudflare account (ADR-0005) and adds the developer as a member.
2. Create an API token in that account with Workers deploy permissions.
3. In the GitHub repo settings, add two Actions secrets:
   - `CLOUDFLARE_API_TOKEN`
   - `CLOUDFLARE_ACCOUNT_ID`

Until those secrets exist, the `deploy` job fails. The `test` job (lint, typecheck, test, OpenNext build) runs independently of them.

To build and preview the Worker locally:

```
npm run cf:preview
```
