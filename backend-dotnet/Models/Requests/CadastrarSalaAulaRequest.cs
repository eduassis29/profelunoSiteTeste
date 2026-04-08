namespace backend_dotnet.Models.Requests
{
    public class CadastrarSalaAulaRequest
    {
        public int IdSalaAula { get; set; }
        public string Titulo { get; set; } = null!;
        public string? Descricao { get; set; }
        public int? IdProfessor { get; set; }
        public DateTime? DataHoraInicio { get; set; }
        public DateTime? DataHoraFim { get; set; }
        public string Materia { get; set; } = null!;
        public int? IdConteudo { get; set; }
        public int QtdAlunos { get; set; }
        public string Url { get; set; } = null!;
        public double Avaliacao { get; set; }
        public string Status { get; set; } = null!;
        public DateTime? CreatedAt { get; set; }
        public DateTime? UpdatedAt { get; set; }
    }
}