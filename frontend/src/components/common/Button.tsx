import type { MouseEventHandler } from "react";

interface ButtonProps {
    name: string;
    className?: string;
    width?: string;
    height?: string;
    onClick?: MouseEventHandler<HTMLButtonElement>;
    type?: "button" | "submit" | "reset";
    icon?: string;
    disabled?: boolean;
}

export default function Button({
    name,
    className = "",
    width = "w-64",
    height = "h-12",
    onClick,
    type = "button",
    icon,
    disabled = false,
}: ButtonProps) {
    const defaultStyleButton = `bg-primary text-black rounded-sm  capitalize
        cursor-pointer font-bold hover:bg-secondary hover:text-black  transition duration-300 ease-in-out gap-2
        `;

    const combinedClassName = `${defaultStyleButton} ${className || ""}`;

    return (
    <button
      type={type}
      onClick={onClick}
      disabled={disabled}
      className={`${width} ${height} ${combinedClassName}`} 
    >
      {icon && <img src={icon} alt="" />} {name}
    </button>
  );
}