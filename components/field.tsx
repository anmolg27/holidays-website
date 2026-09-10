import {
  Children,
  cloneElement,
  isValidElement,
  type ReactElement,
  type ReactNode,
} from "react";

type FieldProps = {
  id: string;
  label: string;
  hint?: string;
  error?: string;
  children: ReactNode;
};

export function Field({ id, label, hint, error, children }: FieldProps) {
  const hintId = hint ? `${id}-hint` : undefined;
  const errorId = error ? `${id}-error` : undefined;
  const describedBy = [hintId, errorId].filter(Boolean).join(" ") || undefined;

  const control = Children.map(children, (child) => {
    if (!isValidElement(child)) {
      return child;
    }

    return cloneElement(
      child as ReactElement<{
        id?: string;
        "aria-invalid"?: boolean;
        "aria-describedby"?: string;
      }>,
      {
        id,
        "aria-invalid": error ? true : undefined,
        "aria-describedby": describedBy,
      },
    );
  });

  return (
    <div className="field">
      <label className="field-label" htmlFor={id}>
        {label}
      </label>
      {control}
      {hint ? (
        <p className="field-hint" id={hintId}>
          {hint}
        </p>
      ) : null}
      {error ? (
        <p className="field-error" id={errorId} role="alert">
          {error}
        </p>
      ) : null}
    </div>
  );
}
