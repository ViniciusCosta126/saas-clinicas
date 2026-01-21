# 📘 Regras de Negócio — Lumina

#### 🗓️ Agendamentos
- Um agendamento pode ser cancelado até 1 hora antes do horário marcado
- Um agendamento pode ter sua presença confirmada
- Um agendamento pode ser:
    - cancelado
    - marcado como falta
    - concluído com sucesso

- Ao cancelar, o agendamento não deve gerar atendimento

- Um profissional não pode possuir dois agendamentos no mesmo horário

- Um paciente não pode possuir dois agendamentos no mesmo horário

- Um agendamento pertence obrigatoriamente a:
    - uma clínica
    - um profissional
    - um paciente
    - uma data e horario

#### 👤 Paciente
- Paciente existe no sistema
- Pode estar em várias clínicas
- Em cada clínica pode ter um profissional diferente

#### 🏥 Clínica

Toda clínica deve possuir:
- um responsável principal
- um email
- um telefone

Uma clínica pode possuir:
- vários pacientes
- vários profissionais
- Um administrador pode também atuar como profissional