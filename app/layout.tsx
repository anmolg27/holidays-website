import type { Metadata } from "next";

export const metadata: Metadata = {
  title: "Uttarakhand Tours",
  description: "Travel packages across Garhwal, Kumaon, and Char Dham.",
};

export default function RootLayout({ children }: LayoutProps<"/">) {
  return (
    <html lang="en">
      <body>{children}</body>
    </html>
  );
}
