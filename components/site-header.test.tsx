import { render, screen } from "@testing-library/react";
import { describe, expect, it } from "vitest";
import { primaryNav } from "../lib/nav";
import { SiteHeader } from "./site-header";

describe("SiteHeader", () => {
  it("exposes a skip link and primary navigation", () => {
    render(<SiteHeader />);

    expect(
      screen.getByRole("link", { name: "Skip to content" }),
    ).toHaveAttribute("href", "#main");
    expect(screen.getByRole("banner")).toBeInTheDocument();
    expect(screen.getByRole("link", { name: "Uttarakhand Tours" })).toHaveAttribute(
      "href",
      "/",
    );

    const nav = screen.getAllByRole("navigation", { name: "Primary" });
    expect(nav.length).toBeGreaterThanOrEqual(1);

    for (const item of primaryNav) {
      const links = screen.getAllByRole("link", { name: item.label });
      expect(links.length).toBeGreaterThanOrEqual(1);
      expect(links[0]).toHaveAttribute("href", item.href);
    }
  });

  it("offers a menu control for small screens", () => {
    render(<SiteHeader />);
    expect(screen.getAllByText("Menu")[0]?.closest("summary")).toBeTruthy();
  });
});
