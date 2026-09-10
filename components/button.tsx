import type { ButtonHTMLAttributes, ReactNode } from "react";

type Variant = "primary" | "secondary" | "ghost";

type ButtonProps = {
  children: ReactNode;
  variant?: Variant;
  href?: string;
} & ButtonHTMLAttributes<HTMLButtonElement>;

export function Button({
  children,
  variant = "primary",
  href,
  className,
  type = "button",
  ...props
}: ButtonProps) {
  const classes = ["button", `button-${variant}`, className]
    .filter(Boolean)
    .join(" ");

  if (href) {
    return (
      <a className={classes} href={href}>
        {children}
      </a>
    );
  }

  return (
    <button className={classes} type={type} {...props}>
      {children}
    </button>
  );
}
