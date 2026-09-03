# Uttarakhand Tours Website

A lead-generation travel website for an Uttarakhand-focused tour company, showcasing curated travel packages that combine cab transportation, hotel accommodation, and guided itineraries across Garhwal, Kumaon, and Char Dham. The site converts visitors into inquiries, not bookings — there is no online payment or checkout.

## Language

**Travel Package**:
A curated, bookable-by-inquiry combination of cab transportation, hotel/homestay accommodation, and a guided itinerary, represented by the `travel_package` custom post type.
_Avoid_: Tour, trip, product

**Lead**:
A visitor's expression of interest, captured via the inquiry form or WhatsApp click-to-chat. Not a confirmed or paid booking — the site never takes payment or confirms availability itself.
_Avoid_: Booking, order, reservation

**Package Region**:
Taxonomy on Travel Package classifying its geography: Garhwal, Kumaon, Char Dham, Border circuits.
_Avoid_: Destination, location, category

**Package Theme**:
Taxonomy on Travel Package classifying its travel style: Pilgrimage, Trekking, Honeymoon, Family, Weekend.
_Avoid_: Category, type, tag

**Mountain Advisory**:
A callout on a Travel Package's page surfacing road conditions, monsoon/weather updates, permit requirements, and recommended gear specific to that package's region/route. Manually written and updated by the client — not a live feed from any external source.
_Avoid_: Notice, alert, disclaimer

**Custom Package Request**:
A Lead submitted through the open-ended inquiry form, where a visitor selects region, dates, passenger count, vehicle, and accommodation tier themselves rather than inquiring about a specific pre-built Travel Package. Never priced automatically.
_Avoid_: Custom package, quote request

**Route Stops**:
The approximate waypoints (place name + coordinates) a Travel Package's journey passes through, plotted on its route map. Not a road-following driving route — just the key stops in order.
_Avoid_: Route, itinerary (itinerary is the day-wise plan; route stops are map waypoints)
