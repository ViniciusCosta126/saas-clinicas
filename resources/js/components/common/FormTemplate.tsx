import '../../../css/components/form-template.scss'

type Props = {
  onSubmit: (e: React.FormEvent<HTMLFormElement>) => void;
  className?: string;
  children: React.ReactNode;
};

export default function FormTemplate({ onSubmit, className, children }: Props) {
  return (
    <form className={className} onSubmit={onSubmit}>
      {children}
    </form>
  );
}
