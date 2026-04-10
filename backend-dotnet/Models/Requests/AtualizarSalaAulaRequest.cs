namespace backend_dotnet.Models.Requests
{
    public class AtualizarSalaAulaRequest
    {
        public int IdSalaAula { get; set; }
        public string Titulo { get; set; } = null!;
        public string? Descricao { get; set; }
        public int? IdProfessor { get; set; }
        public int MaxAlunos { get; set; }
        public DateTimeOffset? DataHoraInicio { get; set; }
        public DateTimeOffset? DataHoraFim { get; set; }
        public int IdMateria { get; set; }
        public string? Status { get; set; }
        public int? IdConteudo { get; set; }
        public int? IdSimulado { get; set; }
        public string Url { get; set; } = null!;
        public string? NomeSala { get; set; }
    }
}