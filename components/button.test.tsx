import { render, screen } from "@testing-library/react";
import { describe, expect, it } from "vitest";
import { Button } from "./button";

describe("Button", () => {
  it("renders a button for actions and a link when given href", () => {
    const { rerender } = render(<Button>Inquire</Button>);
    expect(screen.getByRole("button", { name: "Inquire" })).toHaveClass(
      "button-primary",
    );

    rerender(
      <Button href="/packages" variant="secondary">
        See Travel Packages
      </Button>,
    );
    const link = screen.getByRole("link", { name: "See Travel Packages" });
    expect(link).toHaveAttribute("href", "/packages");
    expect(link).toHaveClass("button-secondary");
  });
});
