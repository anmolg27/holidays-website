import { render, screen } from "@testing-library/react";
import { describe, expect, it } from "vitest";
import { primaryNav } from "../lib/nav";
import { SiteFooter } from "./site-footer";

describe("SiteFooter", () => {
  it("repeats primary navigation and states that inquiries are not bookings", () => {
    render(<SiteFooter />);

    expect(screen.getByRole("contentinfo")).toBeInTheDocument();
    for (const item of primaryNav) {
      expect(screen.getByRole("link", { name: item.label })).toHaveAttribute(
        "href",
        item.href,
      );
    }
    expect(
      screen.getByText(/inquir/i).textContent,
    ).toMatch(/quote or callback/i);
    expect(screen.getByText(/inquir/i).textContent).toMatch(
      /never takes payment/i,
    );
  });
});
