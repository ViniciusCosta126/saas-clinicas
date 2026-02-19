import {
  Chart as ChartJS,
  CategoryScale,
  LinearScale,
  BarElement,
  LineElement,
  PointElement,
  ArcElement,
  Tooltip,
  Legend,
} from 'chart.js'

import { Bar, Line, Doughnut } from 'react-chartjs-2'

import './index.scss'

ChartJS.register(
  CategoryScale,
  LinearScale,
  BarElement,
  LineElement,
  PointElement,
  ArcElement,
  Tooltip,
  Legend
)

type ChartType = 'bar' | 'line' | 'doughnut'

interface Props {
  type: ChartType
  labels: string[]
  data: number[]
  titulo?: string
}

function randomColor(alpha = 0.8) {
  const r = Math.floor(Math.random() * 200)
  const g = Math.floor(Math.random() * 200)
  const b = Math.floor(Math.random() * 200)

  return `rgba(${r}, ${g}, ${b}, ${alpha})`
}

export default function Chart({
  type,
  labels,
  data,
  titulo,
}: Props) {

  const colors =
    type === 'doughnut'
      ? data.map(() => randomColor())
      : randomColor()

  const chartData = {
    labels,
    datasets: [
      {
        label: titulo,
        data,
        backgroundColor: colors,
        borderColor: colors,
        borderRadius: type === 'bar' ? 6 : 0,
        fill: type === 'line',
      }
    ]
  }

  const options: any = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
      legend: {
        display: type === 'doughnut',
        position: 'bottom',
      },
      tooltip: {
        callbacks: {
          label: (context: any) => {
            const value = context.raw ?? 0
            return `R$ ${value.toLocaleString('pt-BR', {
              minimumFractionDigits: 2
            })}`
          }
        }
      }
    }
  }

  if (type === 'doughnut') {
    options.cutout = '65%'
  }

  return (
    <div className="chart">
      {titulo && <h3>{titulo}</h3>}

      <div className="chart-wrapper">
        {type === 'bar' && <Bar data={chartData} options={options} />}
        {type === 'line' && <Line data={chartData} options={options} />}
        {type === 'doughnut' && <Doughnut data={chartData} options={options} />}
      </div>
    </div>
  )
}
