<?php

abstract class Personagem
{
    private string $nome;
    private int $vida;
    private int $ataque;
    private int $defesa;

    public function __construct(
        string $nome,
        int $vida,
        int $ataque,
        int $defesa
    ) {
        $this->nome = $nome;
        $this->vida = $vida;
        $this->ataque = $ataque;
        $this->defesa = $defesa;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function getVida(): int
    {
        return $this->vida;
    }

    public function getAtaque(): int
    {
        return $this->ataque;
    }

    public function getDefesa(): int
    {
        return $this->defesa;
    }

    public function aumentarVida(int $valor): void
    {
        $this->vida += max(0, $valor);
    }

    public function diminuirVida(int $valor): void
    {
        $this->vida = max(0, $this->vida - max(0, $valor));
    }

    public function aumentarAtaque(int $valor): void
    {
        $this->ataque += max(0, $valor);
    }

    public function diminuirAtaque(int $valor): void
    {
        $this->ataque = max(0, $this->ataque - max(0, $valor));
    }

    public function aumentarDefesa(int $valor): void
    {
        $this->defesa += max(0, $valor);
    }

    public function diminuirDefesa(int $valor): void
    {
        $this->defesa = max(0, $this->defesa - max(0, $valor));
    }

    public function receberAtaque(
        int $ataque,
        Personagem $inimigo
    ): void {
        $dano = max(0, $ataque - $this->defesa);

        $this->diminuirVida($dano);

        if ($this->vida == 0) {
            echo "{$this->nome} morreu!<br>";
        } else {
            echo "{$this->nome}: {$this->vida} | ";
            echo "{$inimigo->getNome()}: ";
            echo "{$inimigo->getVida()}<br>";
        }
    }
}


class Guerreiro extends Personagem
{
    public function __construct()
    {
        parent::__construct("Guerreiro", 100, 30, 50);
    }

    public function aplicarAtaqueSimples(
        Personagem $inimigo
    ): void {
        echo "Guerreiro ataca com ataque simples!<br>";

        $inimigo->receberAtaque(
            $this->getAtaque() + 5,
            $this
        );
    }

    public function aplicarAtaqueSelvagem(
        Personagem $inimigo
    ): void {
        echo "Guerreiro ataca com ataque selvagem! ";
        echo "Abaixou a guarda!!<br>";

        $this->diminuirDefesa(10);

        $inimigo->receberAtaque(
            $this->getAtaque() + 10,
            $this
        );
    }

    public function treinar(): void
    {
        $this->aumentarAtaque(10);

        echo "Guerreiro treinou e aumentou sua força!<br>";
    }
}


class Mago extends Personagem
{
    public function __construct()
    {
        parent::__construct("Mago", 100, 60, 20);
    }

    public function aplicarAtaqueMagico(
        Personagem $inimigo
    ): void {
        echo "Mago ataca com ataque mágico! ";
        echo "Defesa aumentada<br>";

        $this->aumentarDefesa(10);

        $inimigo->receberAtaque(
            $this->getAtaque(),
            $this
        );
    }

    public function aplicarSacrificio(
        Personagem $inimigo
    ): void {
        echo "Mago ataca com sacrifício<br>";

        $this->diminuirVida(80);

        echo "Vida do Mago após sacrifício: ";
        echo $this->getVida() . "<br>";

        $inimigo->receberAtaque(
            $this->getAtaque() + 60,
            $this
        );
    }

    public function aplicarBruxaria(): void
    {
        $this->aumentarVida(20);

        echo "Mago usou bruxaria e recuperou vida!<br>";
    }
}


// Executando a batalha

$guerreiro = new Guerreiro();
$mago = new Mago();

$guerreiro->aplicarAtaqueSimples($mago);
$mago->aplicarAtaqueMagico($guerreiro);
$guerreiro->treinar();
$mago->aplicarBruxaria();
$guerreiro->aplicarAtaqueSelvagem($mago);
$mago->aplicarSacrificio($guerreiro);
$guerreiro->aplicarAtaqueSimples($mago);

?>