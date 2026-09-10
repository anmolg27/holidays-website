import Link from "next/link";
import { primaryNav } from "../lib/nav";

function NavList() {
  return (
    <ul className="site-nav-list">
      {primaryNav.map((item) => (
        <li key={item.href}>
          <a href={item.href}>{item.label}</a>
        </li>
      ))}
    </ul>
  );
}

export function SiteHeader() {
  return (
    <header className="site-header">
      <a className="skip-link" href="#main">
        Skip to content
      </a>
      <div className="site-header-bar">
        <Link className="wordmark" href="/" prefetch={false}>
          Uttarakhand Tours
        </Link>
        <nav className="nav-desktop" aria-label="Primary">
          <NavList />
        </nav>
        <details className="nav-mobile">
          <summary>Menu</summary>
          <nav aria-label="Primary">
            <NavList />
          </nav>
        </details>
      </div>
    </header>
  );
}
