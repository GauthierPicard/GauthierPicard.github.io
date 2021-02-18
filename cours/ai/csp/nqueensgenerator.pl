generateQueens(N) :-
	retractall(variables(_)),
	generateNumberList(1,N,Lnb),
	generateVariables(Lnb,1,N,V),
	asserta(variables(V)).

generateNumberList(N,N,[N]) :- !.
generateNumberList(K,N,[K|L]) :-
	Kplus1 is K+1,
	generateNumberList(Kplus1,N,L).

generateVariables(Lnb,N,N,[x(N):Lnb]) :- !.
generateVariables(Lnb,I,N,[x(I):Lnb|Variables]) :-
	Iplus1 is I + 1,
	generateVariables(Lnb,Iplus1,N,Variables).

consistent((x(I),VI),(x(J),VJ)) :-
	VI =\= VJ,
	I+VI =\= J+VJ,
	I-VI =\= J-VJ.
