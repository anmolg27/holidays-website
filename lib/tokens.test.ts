import { describe, expect, it } from "vitest";
import { contrastRatio } from "./contrast";
import { color, pairings } from "./tokens";

describe("design token contrast", () => {
  it.each(pairings)(
    "$role ($fg on $bg) meets WCAG $min:1",
    ({ fg, bg, min }) => {
      expect(contrastRatio(color[fg], color[bg])).toBeGreaterThanOrEqual(min);
    },
  );
});
