import { render, screen } from "@testing-library/react";
import { describe, expect, it } from "vitest";
import { Field } from "./field";

describe("Field", () => {
  it("labels the control and surfaces an error as an alert", () => {
    render(
      <Field
        id="travel-date"
        label="Travel date"
        hint="Approximate start date"
        error="Enter a travel date"
      >
        <input id="travel-date" />
      </Field>,
    );

    expect(screen.getByLabelText("Travel date")).toBeInTheDocument();
    expect(screen.getByText("Approximate start date")).toBeInTheDocument();
    expect(screen.getByRole("alert")).toHaveTextContent("Enter a travel date");
  });
});
