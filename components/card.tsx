import type { ReactNode } from "react";

type CardProps = {
  children: ReactNode;
  href?: string;
};

export function Card({ children, href }: CardProps) {
  if (href) {
    return (
      <a className="card card-link" href={href}>
        {children}
      </a>
    );
  }

  return <article className="card">{children}</article>;
}
