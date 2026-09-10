import type { Metadata } from "next";
import { Button } from "../../components/button";
import { Card } from "../../components/card";
import { Field } from "../../components/field";
import { Section } from "../../components/section";
import { color, space, type } from "../../lib/tokens";

export const metadata: Metadata = {
  title: "Styleguide",
  robots: { index: false, follow: false },
};

const colorRoles = [
  ["ink", "Offset ink", "paper"],
  ["inkMuted", "Secondary ink", "paper"],
  ["paper", "Newsprint", "ink"],
  ["paperDeep", "Recessed plate", "ink"],
  ["cover", "Marigold cover", "ink"],
  ["coverDeep", "Cover shadow", "ink"],
  ["alta", "Sindoor stamp", "paper"],
  ["altaDeep", "Pressed stamp", "paper"],
  ["pine", "Deodar footer", "paper"],
  ["pineBright", "Link pine", "paper"],
  ["white", "Stamp label", "ink"],
  ["rule", "Plate hairline", "ink"],
] as const;

export default function StyleguidePage() {
  return (
    <>
      <Section title="Styleguide">
        <p>
          Visual language for Uttarakhand Tours: a yatra booklet, not a generic
          travel template. Colour, type, spacing, and the four base components
          every later page should consume.
        </p>
      </Section>

      <Section title="Colour">
        <div className="swatch-grid">
          {colorRoles.map(([key, label, ink]) => (
            <div
              className="swatch"
              key={key}
              style={{ background: color[key], color: color[ink] }}
            >
              <p>
                <strong>{label}</strong>
              </p>
              <p>{key}</p>
              <p>{color[key]}</p>
            </div>
          ))}
        </div>
      </Section>

      <Section title="Type scale">
        <p style={{ fontFamily: "var(--font-display-family)", fontSize: type.size.display }}>
          Display — Rasa
        </p>
        <p style={{ fontFamily: "var(--font-display-family)", fontSize: type.size.xl }}>
          Title — the booklet cover
        </p>
        <p style={{ fontSize: type.size.lg }}>Headline</p>
        <p style={{ fontSize: type.size.md }}>Section title</p>
        <p style={{ fontSize: type.size.body }}>
          Body — Atkinson Hyperlegible, sized for a phone in mountain light.
          Measure stays near 70 characters.
        </p>
        <p style={{ fontSize: type.size.sm }}>Small — meta on a package card</p>
        <p style={{ fontSize: type.size.label }}>Label — form fields and folios</p>
      </Section>

      <Section title="Spacing">
        <div className="scale-grid">
          {Object.entries(space).map(([step, value]) => (
            <div className="scale-item" key={step}>
              <div
                style={{
                  width: value,
                  height: value,
                  background: "var(--pine)",
                }}
              />
              <p>
                {step} · {value}
              </p>
            </div>
          ))}
        </div>
      </Section>

      <Section title="Button">
        <div className="button-row">
          <Button>Primary</Button>
          <Button variant="secondary">Secondary</Button>
          <Button variant="ghost">Ghost</Button>
          <Button disabled>Disabled</Button>
        </div>
      </Section>

      <Section title="Card">
        <p className="sample-note">
          Sample layout — not a published Travel Package.
        </p>
        <div className="card-grid">
          <Card href="/packages">
            <h3 className="card-title">Valley walk, sample plate</h3>
            <p className="card-meta">
              <span>Garhwal</span>
              <span>Family</span>
              <span>5 days</span>
            </p>
            <p className="card-price">Starting from ₹ —</p>
          </Card>
          <Card>
            <h3 className="card-title">Static plate</h3>
            <p>
              Cards are booklet plates: one statement, newsprint ground, hairline
              rule. Not nested, not lifted.
            </p>
          </Card>
        </div>
      </Section>

      <Section title="Form field">
        <form>
          <Field
            id="sample-name"
            label="Name"
            hint="As we should address you"
          >
            <input name="name" autoComplete="name" />
          </Field>
          <Field id="sample-region" label="Package Region">
            <select defaultValue="garhwal">
              <option value="garhwal">Garhwal</option>
              <option value="kumaon">Kumaon</option>
              <option value="char-dham">Char Dham</option>
            </select>
          </Field>
          <Field
            id="sample-notes"
            label="Notes"
            error="Add a note so we know what you need"
          >
            <textarea name="notes" />
          </Field>
          <Button type="button">Request a callback</Button>
        </form>
      </Section>

      <Section title="Section shell">
        <p>
          Sections are booklet pages: more space above a heading than below it,
          a shared max width, newsprint around the type. This block is the
          shell.
        </p>
      </Section>
    </>
  );
}

