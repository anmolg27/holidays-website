import Link from "next/link";
import { primaryNav } from "../lib/nav";

export function SiteFooter() {
  return (
    <footer className="site-footer">
      <div className="site-footer-inner">
        <p className="site-footer-mark">Uttarakhand Tours</p>
        <nav className="site-footer-nav" aria-label="Footer">
          <ul>
            {primaryNav.map((item) => (
              <li key={item.href}>
                <a href={item.href}>{item.label}</a>
              </li>
            ))}
            <li>
              <Link href="/styleguide" prefetch={false}>
                Styleguide
              </Link>
            </li>
          </ul>
        </nav>
        <p className="site-footer-note">
          An inquiry requests a quote or callback. This site never takes
          payment or confirms a booking.
        </p>
      </div>
    </footer>
  );
}
