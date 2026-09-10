export function relativeLuminance(hex: string): number {
  const value = hex.replace("#", "");
  if (value.length !== 6) {
    throw new Error(`Expected 6-digit hex colour, received ${hex}`);
  }

  const channel = (start: number) => {
    const srgb = parseInt(value.slice(start, start + 2), 16) / 255;
    return srgb <= 0.04045 ? srgb / 12.92 : ((srgb + 0.055) / 1.055) ** 2.4;
  };

  const r = channel(0);
  const g = channel(2);
  const b = channel(4);
  return 0.2126 * r + 0.7152 * g + 0.0722 * b;
}

export function contrastRatio(foreground: string, background: string): number {
  const lighter = Math.max(
    relativeLuminance(foreground),
    relativeLuminance(background),
  );
  const darker = Math.min(
    relativeLuminance(foreground),
    relativeLuminance(background),
  );
  return (lighter + 0.05) / (darker + 0.05);
}
