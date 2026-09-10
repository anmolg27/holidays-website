import { Button } from "../components/button";

export default function Home() {
  return (
    <section className="cover">
      <div className="cover-inner">
        <h1>Uttarakhand Tours</h1>
        <p>
          Curated Travel Packages — cab, stay, and a guided itinerary — from a
          regional specialist a family can trust with a Char Dham journey.
        </p>
        <Button href="/packages">See Travel Packages</Button>
      </div>
    </section>
  );
}
