# 20: Weekly canary and link checker

**What to build:** A scheduled build whose job is not content but proof — that credentials, dependencies, and outbound links still work, discovered on a quiet Tuesday rather than the moment the client urgently needs to publish (ADR-0004).

**Blocked by:** 09, 10, 17

**Status:** ready-for-agent

- [ ] A weekly cron triggers a full build
- [ ] Failure notifies the developer with enough detail to diagnose it
- [ ] The build HEAD-checks every enabled Useful Link
- [ ] Dead links appear in the existing validation report rather than a separate channel
- [ ] Government sites that block HEAD or bot user-agents can be allowlisted, so the check doesn't cry wolf
- [ ] A successful canary produces no noise
