# 01: Deployable skeleton

**What to build:** A Next.js application that deploys to Cloudflare Workers and serves a page at a real URL. No content, no data — this exists to prove the platform choice works end to end before eighteen other tickets depend on it.

**Blocked by:** None (can start immediately).

**Status:** ready-for-agent

- [ ] A Next.js app builds and deploys to Cloudflare Workers via `@opennextjs/cloudflare`
- [ ] A placeholder page is reachable at a public URL
- [ ] The Cloudflare account is owned by the client, with the developer added as a member (ADR-0005)
- [ ] Deployment runs from CI, not from a developer machine
- [ ] Secrets and environment variables are configured through the platform, never committed
- [ ] A test harness is in place and runs in CI, with at least one passing test
