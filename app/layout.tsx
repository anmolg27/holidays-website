import type { Metadata } from "next";
import type { ReactNode } from "react";
import { Atkinson_Hyperlegible, Rasa } from "next/font/google";
import { SiteFooter } from "../components/site-footer";
import { SiteHeader } from "../components/site-header";
import "./globals.css";

const rasa = Rasa({
  subsets: ["latin"],
  variable: "--font-display",
  display: "swap",
  weight: ["500", "600", "700"],
});

const atkinson = Atkinson_Hyperlegible({
  subsets: ["latin"],
  variable: "--font-body",
  display: "swap",
  weight: ["400", "700"],
});

export const metadata: Metadata = {
  title: "Uttarakhand Tours",
  description: "Travel packages across Garhwal, Kumaon, and Char Dham.",
};

export default function RootLayout({
  children,
}: Readonly<{ children: ReactNode }>) {
  return (
    <html lang="en" className={`${rasa.variable} ${atkinson.variable}`}>
      <body>
        <SiteHeader />
        <main id="main">{children}</main>
        <SiteFooter />
      </body>
    </html>
  );
}
