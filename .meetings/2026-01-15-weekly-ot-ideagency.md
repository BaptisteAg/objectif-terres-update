# Weekly OT x Ideagency Meeting Report
**Date:** January 2026 (Post-holiday return)
**Attendees:** Gael Debost (Developer), Mehdi (Ideagency)
**Absent:** Caro

---

## 1. Duplicate User Accounts Analysis
**Ticket Status:** In Progress (moved to "À mettre en prod" when complete)

Mehdi is finalizing analysis of duplicate user accounts. The approach is case-by-case rather than following a single rule:
- Some cases involve Terre de Liens employees who changed email addresses
- Some are external users who created second accounts
- Decision on which account to keep is based on: last active address, whether it's a TDL employee, and recency of activity

**Action:** Mehdi to complete analysis and move to deployment column when ready.

---

## 2. User Account Creation Issue (ferme.tweetenhausen)
**Ticket Status:** Requires Investigation

**Problem:** User receives "email already exists" error when trying to create account on Laravel, but:
- No trace found in Laravel database
- User detected by Salesforce authentication
- User cannot reset password (receives nothing)
- Not found in Salesforce by Mehdi

**Root Cause Analysis:**
- Salesforce checks username field (not email field) for authentication
- User likely exists in Salesforce "limbo" - has a record but no portal access configured
- Cannot test on staging due to broken Salesforce connection

**Action:** Mehdi to contact Martin (Salesforce admin) to investigate the user's Salesforce record.

---

## 3. Staging Environment Salesforce Connection
**Status:** Broken

The staging environment cannot create new accounts due to Salesforce token/configuration issues. This requires coordination with Martin to fix.

**Action:** Gael to create a ticket and coordinate with Martin for repair (not urgent but needed eventually).

---

## 4. Tickets to Complete Next Week

| Ticket | Description | Owner | Status |
|--------|-------------|-------|--------|
| Archiving survey obligation | Test failure - simple code fix | Gael | In Progress |
| Fraudulent messages prevention | Update prevention message text (content provided in ticket) | Gael | In Progress |
| Single reattribution failure | Previously discussed fix | Gael | In Progress |
| Draft ad saving | Allow saving drafts without all required fields | Gael | Needs Analysis |

---

## 5. Draft Ad Saving Feature Request
**Ticket Status:** Planned (To Do)

**Problem:** Users must fill all required fields before saving a draft. Many users click "Save Draft" and close their browser without noticing validation errors, losing their work.

**Proposed Solution:**
- Required fields should only be mandatory for final submission, not draft saving
- Technical constraint: Some database fields may not allow NULL values

**Implementation Notes (from Gael):**
- Need to handle ads without titles → Display "Annonce sans titre" in the ad list (generated label, not stored in the field)
- Title field remains empty when editing, user must still fill it before final submission

**Action:** Gael to analyze feasibility and estimate effort for next week.

---

## 6. Other Tickets Mentioned
- **URL Modification:** Ticket created as placeholder, not yet specified (lower priority)
- **Duplicate accounts in last column:** Mehdi to complete

---

## Action Items Summary

| Action | Owner | Timeline |
|--------|-------|----------|
| Complete duplicate user analysis | Mehdi | This week |
| Contact Martin about Salesforce user lookup | Mehdi | This week |
| Fix archiving test failure | Gael | Next week |
| Update fraud prevention message | Gael | Next week |
| Fix single reattribution issue | Gael | Next week |
| Analyze draft saving feature | Gael | Next week (estimate) |
| Coordinate with Martin on staging Salesforce fix | Gael | When needed |

---

## Next Meeting
Same time next week - goal is to close all "In Progress" tickets and have analysis ready for the draft saving feature.
