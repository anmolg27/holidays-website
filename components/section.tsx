import type { ReactNode } from "react";

type SectionProps = {
  children: ReactNode;
  title?: string;
  id?: string;
};

export function Section({ children, title, id }: SectionProps) {
  return (
    <section className="section" id={id}>
      <div className="section-inner">
        {title ? <h2 className="section-title">{title}</h2> : null}
        {children}
      </div>
    </section>
  );
}
