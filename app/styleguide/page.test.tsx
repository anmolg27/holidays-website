import { render, screen } from "@testing-library/react";
import { describe, expect, it } from "vitest";
import StyleguidePage from "./page";

describe("Styleguide", () => {
  it("renders tokens and base components for review", () => {
    render(<StyleguidePage />);

    expect(
      screen.getByRole("heading", { name: "Styleguide" }),
    ).toBeInTheDocument();
    expect(screen.getByText("ink")).toBeInTheDocument();
    expect(screen.getByText("Display — Rasa")).toBeInTheDocument();
    expect(screen.getByRole("button", { name: "Primary" })).toBeInTheDocument();
    expect(screen.getByText(/sample layout/i)).toBeInTheDocument();
    expect(screen.getByLabelText("Name")).toBeInTheDocument();
    expect(
      screen.getByRole("heading", { name: "Section shell" }),
    ).toBeInTheDocument();
  });
});
