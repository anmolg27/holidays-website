# Only single-facet archive pages are indexable

Package pages and single-facet archive pages — one Package Region, or one Package Theme — are indexable. Every multi-facet combination, plus all price and duration filters, is served with `noindex` and a canonical pointing at the nearest indexable parent.

Filter combinations multiply into hundreds of URLs whose content overlaps almost entirely. Left indexable, they compete with each other and with the pages that should rank, and they consume crawl budget on a small site that has little to spare. Single-facet pages are the exception because they map to queries people actually type — "garhwal tour packages", "trekking packages uttarakhand" — and are worth a real landing page.

The consequence is that region and theme each need their own intro copy in the sheet. An indexable page with nothing on it but a filtered list is thin content, which is worse than not indexing it at all.

A Travel Package's slug is an explicit column, authored once and independent of its title, because a title edit that silently changes a URL discards whatever ranking that page had. The build fails on a changed slug rather than quietly publishing a new URL. Unpublished packages return 410 Gone, so search engines drop them promptly rather than re-crawling a 404 for weeks.

Deliberately excluded: `AggregateRating` and `Review` structured data on testimonials. Google discounts self-serving review markup collected and displayed by the business itself, and it carries manual-action risk for no ranking benefit.
