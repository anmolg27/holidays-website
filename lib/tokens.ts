export const color = {
  ink: "#1B1F24",
  inkMuted: "#3A423C",
  paper: "#E4E6E1",
  paperDeep: "#D5D7D1",
  cover: "#E8B52A",
  coverDeep: "#C49212",
  alta: "#9C1C16",
  altaDeep: "#7A1410",
  pine: "#1A4336",
  pineBright: "#245C49",
  white: "#FFFFFF",
  rule: "#8A8F88",
} as const;

export const type = {
  display: "Rasa, Georgia, serif",
  body: "Atkinson Hyperlegible, ui-sans-serif, sans-serif",
  size: {
    display: "clamp(2.5rem, 8vw, 4.5rem)",
    xl: "clamp(1.75rem, 4vw, 2.5rem)",
    lg: "1.5rem",
    md: "1.25rem",
    body: "1.0625rem",
    sm: "0.875rem",
    label: "0.8125rem",
  },
} as const;

export const space = {
  1: "0.25rem",
  2: "0.5rem",
  3: "0.75rem",
  4: "1rem",
  5: "1.5rem",
  6: "2rem",
  7: "3rem",
  8: "4rem",
  9: "6rem",
} as const;

export const pairings = [
  { fg: "ink", bg: "paper", min: 4.5, role: "body on newsprint" },
  { fg: "inkMuted", bg: "paper", min: 4.5, role: "secondary text on newsprint" },
  { fg: "ink", bg: "cover", min: 4.5, role: "header text on marigold cover" },
  { fg: "inkMuted", bg: "cover", min: 4.5, role: "secondary text on cover" },
  { fg: "paper", bg: "alta", min: 4.5, role: "primary button label" },
  { fg: "white", bg: "alta", min: 4.5, role: "primary button label on alta" },
  { fg: "paper", bg: "pine", min: 4.5, role: "footer text" },
  { fg: "cover", bg: "pine", min: 3, role: "cover mark on footer" },
  { fg: "alta", bg: "paper", min: 3, role: "focus ring and error on newsprint" },
  { fg: "ink", bg: "paperDeep", min: 4.5, role: "body on recessed plate" },
] as const;
